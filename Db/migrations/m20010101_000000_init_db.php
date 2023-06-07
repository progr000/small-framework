<?php

namespace Db\migrations;

use Core\Exceptions\DbException;
use Core\MigrationDriver;
use Db\migrations\tpl\mMain;

class m20010101_000000_init_db extends mMain
{
    /**
     * You can put in this var string with name
     * of db-connection from config/databases.php
     * to create/modify/delete table from different database
     * instead default (when this var not set)
     * @var string
     */
    //protected static $connection_name = 'postgres-for-developing';

    /**
     * @return bool
     * @throws DbException
     */
    public function up()
    {
        if ($this->db->driver === 'mysql') {

            return $this->exec("
                CREATE TABLE IF NOT EXISTS {{" . MigrationDriver::TABLE_LIST_MIGRATIONS . "}}
                (
                    `" . MigrationDriver::COLUMN_NAME . "` varchar(255) NOT NULL COMMENT 'migration name',
                    UNIQUE KEY `" . MigrationDriver::COLUMN_NAME . "_idx` (`" . MigrationDriver::COLUMN_NAME . "`)
                ) ENGINE = InnoDB
                  COLLATE = 'utf8_general_ci';        
            ");

        } elseif ($this->db->driver === 'pgsql') {

            return $this->exec('
                CREATE TABLE IF NOT EXISTS {{' . MigrationDriver::TABLE_LIST_MIGRATIONS . '}}
                (
                    "' . MigrationDriver::COLUMN_NAME . '" CHARACTER VARYING(255) NOT NULL
                ) WITH (
                    OIDS = FALSE
                )
                TABLESPACE pg_default;
                  
                CREATE UNIQUE INDEX "' . MigrationDriver::COLUMN_NAME . '_idx"
                    ON {{' . MigrationDriver::TABLE_LIST_MIGRATIONS . '}} 
                    USING BTREE ("' . MigrationDriver::COLUMN_NAME . '");       
            ');

        } else {

            return $this->exec('
                CREATE TABLE {{' . MigrationDriver::TABLE_LIST_MIGRATIONS . '}}
                (
                    "' . MigrationDriver::COLUMN_NAME . '" varchar(255) NOT NULL,
                    UNIQUE ("' . MigrationDriver::COLUMN_NAME . '")
                );        
            ');

        }
    }

    /**
     * @return bool
     * @throws DbException
     */
    public function down()
    {
        return $this->exec("DROP TABLE IF EXISTS {{" . MigrationDriver::TABLE_LIST_MIGRATIONS . "}};");
    }
}
