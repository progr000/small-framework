<?php

namespace Models;

use Core\ActiveRecordDriver;


class Test extends ActiveRecordDriver
{
    protected static $connection_name = 'mysql-for-developing';
}