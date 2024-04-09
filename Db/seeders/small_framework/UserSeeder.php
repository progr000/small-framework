<?php

namespace Db\seeders\small_framework;

use Core\Exceptions\DbException;
use Core\SeederDriver;
use Models\User;

class UserSeeder extends SeederDriver
{
    /**
     * @throws DbException
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