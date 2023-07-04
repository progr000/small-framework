<?php

namespace Models;

use Core\ActiveRecordDriver;
use Core\App;
use Core\Exceptions\DbException;

/**
 * Class User
 * @package Models
 * @property int $id
 * @property string $username
 * @property string $password
 * @property int $role
 */
class User extends ActiveRecordDriver
{
    //protected static $connection_name = 'mysql-for-developing';

    const ROLE_ADMIN = 0;
    const ROLE_MODER = 1;
    const ROLE_USER = 2;

    /**
     * @param null $role
     * @return array|string
     */
    public static function getRoles($role = null)
    {
        $ret = [
            self::ROLE_ADMIN => __('Admin'),
            self::ROLE_MODER => __('Moderator'),
            self::ROLE_USER => __('User'),
        ];

        if (!is_null($role) && isset($ret[$role])) {
            return $ret[$role];
        }

        return $ret;
    }

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
            App::$user = $user;
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
        App::$user = null;
        return true;
    }

    /**
     * @param string $username
     * @param string $plain_password
     * @return string
     */
    public static function generatePassword($username, $plain_password)
    {
        return md5($username . $plain_password . config('cookie-enc-key', 'cookie-enc-key-value'));
    }

}
