<?php
namespace Console;

use Core\ConsoleDriver;
use Core\Exceptions\DbException;
use Core\Exceptions\IntegrityException;
use Core\LogDriver;
use Core\MigrationDriver;
use Db\seeders\DbSeeder;
use Exception;

class seed extends ConsoleDriver
{
    /** @var string[] */
    protected $available_params = [
        'seed:run' => " [warn][--class=CLASS][/warn]",
        '--class' => "\t\t\t\tThe class name of the root seeder [warn][default: DbSeeder][/warn]",
    ];

    /** @var MigrationDriver */
    private $seeder;
    protected $class;
    protected $name;
    protected $delete_lock = 'false';

    /**
     * @return true
     * @throws Exception
     */
    public function init()
    {
        ignore_user_abort(true);
        LogDriver::setVerboseLevel($this->verbose_level);
        //LogDriver::setLog(config('logs->migrations.log'));
        //$this->seeder = ''
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
        if (isset($actions['--class'])) {
            $this->class = $actions['--class'];
        } else {
            $this->class = DbSeeder::class;
        }

        return true;
    }

    /**
     * @return void
     * @throws DbException
     */
    protected function run()
    {
        if (class_exists($this->class)) {
            $class = $this->class;
        } elseif (class_exists('Db\\seeders\\' . $this->class)) {
            $class = 'Db\\seeders\\' . $this->class;
        }

        if (isset($class)) {
            if (method_exists($class, 'run')) {
                LogDriver::warning("Start seeding for {$this->class}");
                $seeder = new $class();
                $seeder->run();
                LogDriver::info("Finish seeding for {$this->class}");
            } else {
                LogDriver::error("The '{$this->class}' class is incorrect, it doesn't have a run() method.");
            }
        } else {
            LogDriver::error("Class '{$this->class}' not found");
        }
    }
}
