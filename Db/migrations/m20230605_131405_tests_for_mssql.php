<?php

namespace Db\migrations;

use Core\Exceptions\DbException;
use Db\migrations\tpl\mMain;
use PDOStatement;

class m20230605_131405_tests_for_mssql extends mMain
{
    /**
     * You can put in this var string with name
     * of db-connection from config/databases.php
     * to create/modify/delete table from different database
     * instead default (when this var not set)
     * @var string
     */
    protected static $connection_name = 'mssql-for-developing';

    /**
     * @return false|PDOStatement
     * @throws DbException
     */
    public function up()
    {
        return $this->db->exec("
            CREATE TABLE {{tests_for_mssql}} (
                id INT IDENTITY(1,1) PRIMARY KEY,
                amount DECIMAL(10, 2) NULL DEFAULT 0.00,
                email VARCHAR(35) DEFAULT NULL,
                name VARCHAR(35) NOT NULL,
                UNIQUE (email)
            );
        ");
    }

    /**
     * @return false|PDOStatement
     * @throws DbException
     */
    public function down()
    {
        return $this->db->exec("
            DROP TABLE IF EXISTS {{tests_for_mssql}};
        ");
    }
}
