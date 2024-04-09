<?php

namespace Db\seeders\small_framework;

use Core\SeederDriver;

class TestSeeder extends SeederDriver
{
    /**
     * @inheritdoc
     */
    public function run()
    {
        //dump('TestSeeder->run()');
        //return false;
        return true;
    }
}