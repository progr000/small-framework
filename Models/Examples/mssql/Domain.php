<?php

namespace Models\Examples\mssql;

use Core\ActiveRecordDriver;

class Domain extends ActiveRecordDriver
{
    protected static $connection_name = 'mssql-wl-domain';
    protected static $_table_name = '{{domain}}';
}