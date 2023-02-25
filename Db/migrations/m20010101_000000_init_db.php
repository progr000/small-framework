<?php

namespace Db\migrations;

use Core\App;
use Core\MigrationDriver;

class m20010101_000000_init_db
{
    /**
     * @return false|\PDOStatement
     */
    public function up()
    {
        return App::$db->exec("
            CREATE TABLE IF NOT EXISTS `" . MigrationDriver::TABLE_LIST_MIGRATIONS . "`
            (
                `" . MigrationDriver::COLUMN_NAME . "` varchar(255) NOT NULL COMMENT 'migration name',
                UNIQUE KEY (`" . MigrationDriver::COLUMN_NAME . "`)
            ) ENGINE = InnoDB
              COLLATE = 'utf8_general_ci';        
        ");
    }

    /**
     * @return false|\PDOStatement
     */
    public function down()
    {
        return App::$db->exec("DROP TABLE IF EXISTS `" . MigrationDriver::TABLE_LIST_MIGRATIONS . "`;");
    }
}
