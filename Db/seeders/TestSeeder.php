<?php

namespace Db\seeders;

use Core\SeederDriver;

class TestSeeder extends SeederDriver
{
    public function run()
    {
        dump('TestSeeder->run()');
    }
}