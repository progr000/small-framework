<?php

namespace Db\seeders\small_framework;

use Maksym\Config\ConfigException;
use Maksym\Db\Exceptions\DbException;
use Maksym\Db\SeederDriver;
use Models\User;

class UserSeeder extends SeederDriver
{
    /**
     * @throws DbException|ConfigException
     */
    public function run()
    {
        $init_username = 'admin';
        $init_password = 'fdlhDFDSFD$SVfdodjosdjof434543fs233@';

        $user = User::firstOrNew(['username' => 'admin']);
        $user->username = $init_username;
        $user->password = User::generatePassword($init_username, $init_password);
        $user->role = User::ROLE_ADMIN;
        return $user->save();
    }
}