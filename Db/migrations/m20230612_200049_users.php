<?php

namespace Db\migrations;

use Maksym\Config\ConfigException;
use Maksym\Db\Exceptions\DbException;
use Db\migrations\tpl\mMain;

class m20230612_200049_users extends mMain
{
    /**
     * You can put in this var string with name
     * of db-connection from config/databases.php
     * to create/modify/delete table from different database
     * instead default (when this var not set)
     * @var string
     */
    //protected static $connection_name;

    /**
     * @return false
     * @throws DbException|ConfigException
     */
    public function up()
    {
        return $this->exec("
            CREATE TABLE IF NOT EXISTS {{users}}
            (
                `id`              int          NOT NULL AUTO_INCREMENT COMMENT 'internal record id',
                `username`        varchar(55)  NOT NULL                COMMENT 'name',
                `password`        varchar(255) NOT NULL                COMMENT 'password',
                `role`            smallint NOT NULL DEFAULT 0          COMMENT 'user-role',
                PRIMARY KEY (`id`),
                UNIQUE KEY `username_idx` (`username`)
            ) ENGINE = InnoDB
              COLLATE = 'utf8_general_ci';  
        ");
    }

    /**
     * @return false
     * @throws DbException|ConfigException
     */
    public function down()
    {
        return $this->exec("
            DROP TABLE IF EXISTS {{users}};
        ");
    }
}
