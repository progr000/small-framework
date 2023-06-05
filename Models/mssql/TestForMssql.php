<?php

namespace Models\mssql;

use Core\ActiveRecordDriver;


class TestForMssql extends ActiveRecordDriver
{
    protected static $connection_name = 'mssql-for-developing';
    protected static $_table_name = 'tbl_tests_for_mssql';
}