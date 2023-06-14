<?php

namespace Controllers;

use Core\App;
use Core\ControllerDriver;
use Core\Exceptions\DbException;
use Core\LogDriver;
use Core\RequestDriver;
use Middleware\Auth;
use Models\User;
use Requests\ChangePasswordRequest;
use Services\FlashMessages;

class AdminController extends ControllerDriver
{
    /**
     *
     */
    public function __construct()
    {
        /* check is user authenticated */
        $auth = new Auth();
        $auth->handle(App::$request);

        /* change layouts global for all methods in this controller */
        App::$config->set('template-path', config('admin-template-path'));
        $this->layout = "layouts/main";
    }

    /**
     * @return \Exception|string
     * @throws DbException
     */
    public function dashboard()
    {
        return $this->render('pages/dashboard');
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

        $TASK_DIR = __DIR__ . "/../Console";


        /* route */
        $_task['task'] = $r->get('task');
        if ($_task['task']) {

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

            $tasks = scandir($TASK_DIR);
            array_splice($tasks, array_search('.', $tasks ), 1);
            array_splice($tasks, array_search('..', $tasks ), 1);


            $Usage = LogDriver::createMessage("\n", 0)
                ->messageAppend("Please determine the Task\n")
                ->messageAppend("Usage [warn]" . $r->route() . "?task=TaskName[/warn]\n")
                ->messageAppend("[default]---------------------------[/default]\n")
                ->messageAppend("Available tasks:\n");

            foreach ($tasks as $task) {
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
        //echo $data;
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
            User::update(['password' => User::generatePassword(session('Auth')->username, $data['password'])], ['id' => session('Auth')->id]);
            //set_flash_messages('Password was successfully changed', FLASH_SUCCESS);
            FlashMessages::success('Password was successfully changed');
            return $this->redirect('/admin-panel/change-password?success');
        } else {
            return $this->render('pages/change-password');
        }
    }

    /**
     * @return \Exception|string
     * @throws DbException
     */
    public function users()
    {
        return $this->render('pages/users', [
            'users' => User::find()->orderBy(['id' => 'ASC'])->get(),
        ]);
    }
}