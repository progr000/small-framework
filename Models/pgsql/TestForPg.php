<?php

namespace Models\pgsql;

use Core\ActiveRecordDriver;


class TestForPg extends ActiveRecordDriver
{
    protected static $connection_name = 'postgres-for-developing';
    protected static $_table_name = 'tbl_tests_for_pg';
}