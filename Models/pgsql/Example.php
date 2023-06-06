<?php

namespace Models\pgsql;

use Core\ActiveRecordDriver;


class Example extends ActiveRecordDriver
{
    protected static $connection_name = 'postgres-for-developing';
    protected static $_table_name = '{{examples}}';
}