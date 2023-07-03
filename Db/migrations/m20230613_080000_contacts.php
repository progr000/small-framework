<?php

namespace Db\migrations;

use Core\Exceptions\DbException;
use Db\migrations\tpl\mMain;

class m20230613_080000_contacts extends mMain
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
        return $this->exec("
            CREATE TABLE IF NOT EXISTS {{contacts}}
            (
                `id`              int          NOT NULL AUTO_INCREMENT COMMENT 'internal record id',
                `name`            varchar(55)  NOT NULL                COMMENT 'name',
                `email`           varchar(255)          DEFAULT NULL   COMMENT 'email',
                `phone`           varchar(55)  NOT NULL DEFAULT ''     COMMENT 'phone',
                `subject`         varchar(255) NOT NULL DEFAULT ''     COMMENT 'phone',
                `msg`             text                  DEFAULT NULL   COMMENT 'message',
                PRIMARY KEY (`id`),
                KEY `email_idx` (`email`),
                KEY `phone_idx` (`phone`)
            ) ENGINE = InnoDB
              COLLATE = 'utf8_general_ci';        
        ");
    }

    /**
     * @return false
     * @throws DbException
     */
    public function down()
    {
        return $this->exec("
            DROP TABLE IF EXISTS {{contacts}};
        ");
    }
}
