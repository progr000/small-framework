<?php

namespace Models;

use Core\ActiveRecordDriver;
use Core\App;
use Core\Exceptions\DbException;

class User extends ActiveRecordDriver
{
    //protected static $connection_name = 'mysql-for-developing';

    const ROLE_ADMIN = 0;
    const ROLE_USER = 1;

    /**
     * @param string $username
     * @param string $password
     * @return bool
     * @throws DbException
     */
    public static function login($username, $password)
    {
        $user = self::findOne(['username' => $username, 'password' => self::generatePassword($username, $password), 'role' => self::ROLE_ADMIN]);
        if ($user) {
            session()->set('Auth', $user);
            return true;
        }

        return false;
    }

    /**
     * @return true
     */
    public static function logout()
    {
        session()->delete('Auth');
        return true;
    }

    /**
     * @param $username
     * @param $plain_password
     * @return string
     */
    public static function generatePassword($username, $plain_password)
    {
        return md5($username . $plain_password . config('cookie-enc-key', 'cookie-enc-key-value'));
    }

}