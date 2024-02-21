<?php

namespace Db\seeders;

use Core\SeederDriver;

class DbSeeder extends SeederDriver
{
    public function run()
    {
        $this->call([
            TestSeeder::class,
        ]);
    }
}