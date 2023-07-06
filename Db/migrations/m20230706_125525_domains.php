<?php

namespace Db\migrations;

use Core\Exceptions\DbException;
use Db\migrations\tpl\mMain;

class m20230706_125525_domains extends mMain
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
            CREATE TABLE IF NOT EXISTS {{domains}}
            (
                `id`       int          NOT NULL AUTO_INCREMENT COMMENT 'internal record id',
                `domain`   varchar(255) NOT NULL                COMMENT 'domain',
                `date_reg` datetime     NOT NULL                COMMENT 'date_reg',
                `status`   smallint     NOT NULL DEFAULT 0      COMMENT 'status',
                PRIMARY KEY (`id`),
                KEY `domain_idx` (`domain`)
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
            DROP TABLE IF EXISTS {{domains}};
        ");
    }
}
