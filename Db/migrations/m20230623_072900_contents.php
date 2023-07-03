<?php

namespace Db\migrations;

use Core\Exceptions\DbException;
use Db\migrations\tpl\mMain;

class m20230623_072900_contents extends mMain
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
            CREATE TABLE IF NOT EXISTS {{contents}}
            (
                `id`    int          NOT NULL AUTO_INCREMENT COMMENT 'internal record id',
                `key`   varchar(55)  NOT NULL                COMMENT 'key',
                `value` text                                 COMMENT 'value',
                PRIMARY KEY (`id`),
                UNIQUE KEY `key_idx` (`key`)
            ) ENGINE = InnoDB
              COLLATE = 'utf8_general_ci';

            INSERT INTO {{contents}} (`key`, `value`) VALUES ('SOME_KEY_1','<h5 class=\"h5-xl red-color\">Action #1</h5>\r\n<h6 class=\"h6-xl\"><span>33 Juni 2097</span></h6>\r\n<p class=\"grey-color\">8:00 - 21:00</p>');
            INSERT INTO {{contents}} (`key`, `value`) VALUES ('LINK_FACEBOOK','https://de-de.facebook.com/');
            INSERT INTO {{contents}} (`key`, `value`) VALUES ('LINK_INSTAGRAM','https://www.instagram.com/');
            INSERT INTO {{contents}} (`key`, `value`) VALUES ('FOOTER_ADDRESS','<p>8717, Benken,</p>\r\n<p>Speerstrasse 1,</p>\r\n<p>Schweiz</p>');
            INSERT INTO {{contents}} (`key`, `value`) VALUES ('HEADER_PHONE','+41795140835');
        ");

    }

    /**
     * @return false
     * @throws DbException
     */
    public function down()
    {
        return $this->exec("
            DROP TABLE IF EXISTS {{contents}};
        ");
    }
}
