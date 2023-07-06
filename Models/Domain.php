<?php

namespace Models;

use Core\ActiveRecordDriver;
use Core\Exceptions\DbException;

/**
 * Class User
 * @package Models
 * @property int $id
 * @property string $domain
 * @property string $date_reg
 * @property int $status
 */
class Domain extends ActiveRecordDriver
{
    //protected static $connection_name = 'mysql-for-developing';
}