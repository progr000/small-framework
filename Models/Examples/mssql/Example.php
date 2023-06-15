<?php

namespace Models\Examples\mssql;

use Core\ActiveRecordDriver;

class Example extends ActiveRecordDriver
{
    protected static $connection_name = 'mssql-for-developing';
    protected static $_table_name = '{{examples}}';
}