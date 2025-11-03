<?php

namespace Db\seeders\small_framework;

use Core\App;
use Maksym\Db\DbDriver;
use Maksym\Db\SeederDriver;

class _MainSeeder extends SeederDriver
{
    /**
     * @return bool
     */
    public function run()
    {
        DbDriver::$DbInstances['mysql-for-developing']->beginTransaction();

        if ($this->call([
            //TestSeeder1::class,
            TestSeeder::class,
            UserSeeder::class,
        ])) {
            DbDriver::$DbInstances['mysql-for-developing']->commit();
            return true;
        }

        DbDriver::$DbInstances['mysql-for-developing']->rollback();
        return false;
    }
}