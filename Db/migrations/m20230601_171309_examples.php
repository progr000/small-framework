<?php

namespace Db\migrations;

use Core\Exceptions\DbException;
use Db\migrations\tpl\mMain;

class m20230601_171309_examples extends mMain
{
    /**
     * You can put in this var string with name
     * of db-connection from config/databases.php
     * to create/modify/delete table from different database
     * instead default (when this var not set)
     * @var string
     */
    //protected static $connection_name = 'mysql-for-developing';

    /**
     * @return bool
     * @throws DbException
     */
    public function up()
    {
        return $this->exec("
            CREATE TABLE IF NOT EXISTS {{examples}}
            (
                `id`              int                     NOT NULL AUTO_INCREMENT COMMENT 'internal record id',
                `amount`          DECIMAL(10, 2) UNSIGNED NOT NULL DEFAULT '0.00' COMMENT 'amount',
                `email`           varchar(35)                      DEFAULT NULL COMMENT 'just email',
                `name`            varchar(35)             NOT NULL COMMENT 'just name',
                PRIMARY KEY (`id`),
                UNIQUE KEY `email_idx` (`email`)
            ) ENGINE = InnoDB
              COLLATE = 'utf8_general_ci';        
        ");
    }

    /**
     * @return bool
     * @throws DbException
     */
    public function down()
    {
        return $this->exec("
            DROP TABLE IF EXISTS {{examples}};
        ");
    }
}
