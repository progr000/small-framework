<?php

namespace Models;

use Core\ActiveRecordDriver;

/**
 * Class Contact
 * @package Models
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $phone
 * @property string $subject
 * @property int $msg
 * @property int $is_new
 * @property int $created_at
 */
class Contact extends ActiveRecordDriver
{
    //protected static $connection_name = 'mysql-for-developing';
    const IS_NEW = 1;
    const IS_OLD = 0;
}