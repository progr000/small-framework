<?php

namespace Db\seeders;

use Core\SeederDriver;
use Db\seeders\small_framework\_MainSeeder as SF_MainSeeder;

class DbSeeder extends SeederDriver
{
    /**
     * @return bool
     */
    public function run()
    {
        return $this->call([
            SF_MainSeeder::class,
        ]);
    }
}