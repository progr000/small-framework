<?php

namespace Controllers\AdminPanel;

use Core\App;
use Core\Exceptions\DbException;
use Core\Exceptions\HttpNotFoundException;
use Core\LogDriver;
use Core\RequestDriver;
use Core\ResponseDriver;
use Ifsnop\Mysqldump\Mysqldump;
use Middleware\Auth;
use Models\Contact;
use Models\User;
use Requests\ChangePasswordRequest;
use Services\FlashMessages;
use Ifsnop\Mysqldump as IMysqldump;

class AdminController extends _MainController
{
    /**
     *
     */
    public function __construct()
    {
        /* check is user authenticated */
        $auth = new Auth();
        $auth->handleOnRequest(App::$request, App::$response);

        /**/
        parent::__construct();
    }

    /**
     * @return \Exception|string
     * @throws DbException
     */
    public function dashboard()
    {
        return $this->render('pages/dashboard', [
            'new_contacts_count' => Contact::find()->where(['is_new' => Contact::IS_NEW])->count(),
        ]);
    }

    /**
     * @param RequestDriver $r
     * @return \Exception|string
     */
    public function webConsole(RequestDriver $r)
    {
        set_time_limit(0);

        ob_start();
        LogDriver::beginConsole();

        $TASK_DIR = __DIR__ . "/../../Console";


        /* route */
        $_task = $r->get();
        if (isset($_task['task'])) {

            $tmp = explode(':', $_task['task']);
            if (sizeof($tmp) == 2) {
                $_task['task'] = $tmp[0];
                $_task[$tmp[1]] = null;
            }

            $_task['task'] = basename($_task['task']);

            if (file_exists($TASK_DIR . "/{$_task['task']}.php")) {

                /* Show back-link */
                LogDriver::warning("<a href=\"{$r->route()}\" data-off-onclick=\"history.back()\">[warn]&lt;&lt;&lt;[BACK][/warn]</a>\n", 0);

                /* prepare route and params */
                $route = 'Console\\' . $_task['task'];
                unset($_task['task']);
                $arguments = [];
                foreach ($_task as $k => $v) {
                    if (empty($v)) $arguments[] = $k;
                    else $arguments[] = "{$k}={$v}";
                }

                /* Run task */
                new $route($arguments);

            } else {
                $show_usage = true;
            }

        } else {
            $show_usage = true;
        }


        if (isset($show_usage)) {

            $Usage = LogDriver::createMessage("\n", 0)
                ->messageAppend("Please determine the Task\n")
                ->messageAppend("Usage [warn]" . $r->route() . "?task=TaskName[/warn]\n")
                ->messageAppend("[default]---------------------------[/default]\n")
                ->messageAppend("Available tasks:\n");

            $tasks = glob($TASK_DIR . '/*.php');
            foreach ($tasks as $task) {
                $task = basename($task);
                if (strrpos($task,'.php') !== false) {
                    $task = str_replace('.php', '', $task);
                    $link = '<a href="' . $r->route() . '?task=' . $task . '">[success]' . $task . '[/success]</a>';
                    $Usage->messageAppend("\t" . $link . "\n");
                }
            }
            $Usage->setType("info")->show(false, false);
        }

        LogDriver::endConsole();

        $data = ob_get_contents();
        ob_end_clean();

        return $this->render('pages/web-console', ['data' => $data]);
    }

    /**
     * @param RequestDriver $r
     * @return \Core\ResponseDriver|\Exception|string
     * @throws DbException
     */
    public function changePassword(RequestDriver $r)
    {
        if ($r->isPost()) {
            $r = new ChangePasswordRequest();
            $data = $r->validated();
            User::update(['password' => User::generatePassword(App::$user->username, $data['password'])], ['id' => App::$user->id]);
            FlashMessages::success(__('Password was successfully changed'));
            return $this->redirect(url('/admin-panel/change-password?success'));
        } else {
            return $this->render('pages/change-password');
        }
    }

    /**
     * @return \Exception|string
     */
    public function phpinfo()
    {
        $a = 2;
        echo App::$cache->cacheResult(function () use ($a) {
            dump($a);
            return date('Y-m-d H:i:s');
        }, 30);
        ob_start();
        phpinfo();
        $data = ob_get_contents();
        ob_end_clean();

        $tmp = explode('<body>', $data);
        $body = isset($tmp[1]) ? $tmp[1] : '';
        $tmp = explode('</body>', $body);
        $body = $tmp[0];

        return $this->render('pages/web-console', ['phpinfo' => true, 'data' => $body]);
    }

    /**
     * @param RequestDriver $request
     * @return ResponseDriver|\Exception|string|void
     * @throws HttpNotFoundException
     */
    public function backupDatabase(RequestDriver $request)
    {
        $backup_dir = rtrim(config('backup-database-path'), "/") . "/";
        if ($request->isPost()) {

            try {
                $dumpSettings = [
                    //'include-tables' => array('table1', 'table2'),
                    //'exclude-tables' => array('table3', 'table4'),
                    'compress' => Mysqldump::GZIP, /* CompressMethod::[GZIP, BZIP2, NONE] */
                    //'no-data' => false,
                    //'add-drop-table' => false,
                    //'single-transaction' => true,
                    //'lock-tables' => false,
                    //'add-locks' => true,
                    'extended-insert' => false,
                ];
                $dump = new IMysqldump\Mysqldump(
                    config('databases->mysql-for-developing')['dsn'],
                    config('databases->mysql-for-developing')['user'],
                    config('databases->mysql-for-developing')['password'],
                    $dumpSettings
                );

                @mkdir($backup_dir, 0777, true);
                @chmod($backup_dir, 0777);
                $file_name = $backup_dir . date('Ymd_His') . '_dump.sql.gz';

                $dump->start($file_name);

                @chmod($file_name, 0777);
                FlashMessages::success(__("Backup file &laquo{%file_name}&raquo successfully created" , ['file_name' => $file_name]), 15);
            } catch (\Exception $e) {
                FlashMessages::error(__("Fail on create backup file. Error: {%error}", ['error' => $e->getMessage()]), 15);
            }
            return $this->redirect(url('/admin-panel/backup-database'));

        } elseif ($request->isDelete() && $request->all('file_name')) {

            $file_name = $backup_dir . basename($request->all('file_name'));
            if (file_exists($file_name)) {
                @unlink($file_name);
                FlashMessages::success(__("Backup file &laquo{%file_name}&raquo successfully deleted", ['file_name' => $file_name]), 15);
                return $this->redirect(url('/admin-panel/backup-database'));
            } else {
                FlashMessages::error(__("Fail on delete backup file &laquo{%file_name}&raquo", ['file_name' => $file_name]), 15);
                throw new HttpNotFoundException("File doesn't exists");
            }

        } elseif ($request->get('download')) {

            $file_name = $backup_dir . basename($request->get('download'));
            if (file_exists($file_name)) {
                return App::$response
                    ->setBody(file_get_contents($file_name))
                    ->asFile($file_name);
            } else {
                FlashMessages::error(__("Fail on download backup file &laquo{%file_name}&raquo", ['file_name' => $file_name]), 15);
                throw new HttpNotFoundException("File doesn't exists");
                //return $this->redirect(url('/admin-panel/backup-database'));
            }

        } else {

            $list_of_dumps = glob($backup_dir . "*_dump.sql.gz");
            return $this->render('pages/backup-database', ['list_of_dumps' => $list_of_dumps]);

        }
    }
}