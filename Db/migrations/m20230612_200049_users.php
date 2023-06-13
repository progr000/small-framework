<?php

namespace Db\migrations;

use Core\Exceptions\DbException;
use Db\migrations\tpl\mMain;
use Models\User;

class m20230612_200049_users extends mMain
{
    /**
     * You can put in this var string with name
     * of db-connection from config/databases.php
     * to create/modify/delete table from different database
     * instead default (when this var not set)
     * @var string
     */
    protected static $connection_name;

    /**
     * @return false
     * @throws DbException
     */
    public function up()
    {
        $init_username = 'admin';
        $init_password = 'test';
        $init_password_enc = User::generatePassword($init_username, $init_password);

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

            INSERT INTO {{users}} (username, password, role) VALUES ('admin', '{$init_password_enc}', 0);
        ");
    }

    /**
     * @return false
     * @throws DbException
     */
    public function down()
    {
        return $this->exec("
            DROP TABLE IF EXISTS {{users}};
        ");
    }
}
