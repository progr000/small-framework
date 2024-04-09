<?php

namespace Db\seeders\small_framework;

use Core\App;
use Core\SeederDriver;

class _MainSeeder extends SeederDriver
{
    /**
     * @return bool
     */
    public function run()
    {
        App::$DbInstances['mysql-for-developing']->beginTransaction();

        if ($this->call([
            //TestSeeder1::class,
            TestSeeder::class,
            UserSeeder::class,
        ])) {
            App::$DbInstances['mysql-for-developing']->commit();
            return true;
        }

        App::$DbInstances['mysql-for-developing']->rollback();
        return false;
    }
}