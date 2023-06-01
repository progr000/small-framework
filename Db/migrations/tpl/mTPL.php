<?php

namespace Db\migrations;

use Core\Exceptions\DbException;
use Db\migrations\tpl\mMain;
use PDOStatement;

class __NEW_CLASS_NAME__ extends mMain
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
     * @return false|PDOStatement
     * @throws DbException
     */
    public function up()
    {
        return $this->db->exec("/* PUT HERE YOUR SQL */");
    }

    /**
     * @return false|PDOStatement
     * @throws DbException
     */
    public function down()
    {
        return $this->db->exec("/* PUT HERE YOUR SQL */");
    }
}
