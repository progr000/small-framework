<?php
namespace Console;

use Core\ConsoleDriver;
use Core\Exceptions\DbException;
use Core\LogDriver;
use Core\MigrationDriver;
use Exception;

class migrate extends ConsoleDriver
{
    /** @var string[] */
    protected $available_params = [
        'migrate:up'      => " [warn][ --set-steps=INT ][/warn]\tInstall all new migrations",
        'migrate:down'    => " [error]--set-steps=INT[/error]\tUninstall some migrations",
        'migrate:create'  => " [error]--set-name=NAME[/error]\tCreate new migration file",
        'migrate:refresh' => "\t\t\tReinstall all migration (full down an then full up)",
        'migrate:reset'   => "\t\t\tUninstall all migration",
        '--set-steps'     => "=INT\t\t\tRequired with :down and not necessarily with :up",
        '--set-name'      => "=NAME\t\t\tRequired with :create",
        '--web-version-help' => "\t\tShow how you can use this through http"
    ];

    /** @var MigrationDriver */
    private $migrate;
    protected $steps;
    protected $name;

    /**
     * @return true
     * @throws Exception
     */
    public function init()
    {
        ignore_user_abort(true);
        LogDriver::setVerboseLevel($this->verbose_level);
        LogDriver::setLog(config('logs->migrations.log'));
        $this->migrate = MigrationDriver::getInstance(__DIR__ . "/../Db/migrations");
        return true;
    }

    /**
     * Function for prepare and validate variables and environment
     * before someMethod will be run by starter.
     * @param array $actions
     * @return bool
     */
    public function validate(array $actions)
    {
        if (key_exists('down', $actions) && !isset($actions['--set-steps'])) {
            LogDriver::warning("For migrate:down you do not set --set-steps param, only one migration will be undo", 0, false, false);
            $this->steps = 1;
        }

        if (key_exists('create', $actions) && !isset($actions['--set-name'])) {
            LogDriver::error("For migrate:create action you must set param --set-name=STRING", 0, false, false);
            return false;
        }

        if (isset($actions['--set-steps'])) {
            $this->steps = intval($actions['--set-steps']);
        }

        return true;
    }

    /**
     * @return void
     * @throws DbException
     */
    protected function up()
    {
        $this->migrate->up($this->steps);
    }

    /**
     * @return void
     * @throws DbException
     */
    protected function down()
    {
        $this->migrate->down($this->steps);
    }

    /**
     * @return void
     */
    protected function create()
    {
        $this->migrate->create($this->name);
    }

    /**
     * @return void
     * @throws DbException
     */
    protected function refresh()
    {
        $this->migrate->refresh();
    }

    /**
     * @return void
     * @throws DbException
     */
    protected function reset()
    {
        $this->migrate->reset();
    }

    /**
     * @return void
     */
    protected function webVersionHelp()
    {
        LogDriver::createMessage("\n")
            ->messageAppend("/admin/webland/console/web-console-runner.php?task=migrate:create&--set-name=NAME\n")
            ->messageAppend("/admin/webland/console/web-console-runner.php?task=migrate:up&--set-steps=INT\n")
            ->messageAppend("/admin/webland/console/web-console-runner.php?task=migrate:down&--set-steps=INT\n")
            ->messageAppend("/admin/webland/console/web-console-runner.php?task=migrate:refresh\n")
            ->messageAppend("/admin/webland/console/web-console-runner.php?task=migrate:reset\n")
            ->setType('warning')
            ->setLevel(0)
            ->show(false, false);
    }
}
