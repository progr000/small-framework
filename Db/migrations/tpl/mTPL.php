<?php

namespace Db\migrations;

use Db\migrations\tpl\mMain;
use Maksym\Config\ConfigException;
use Maksym\Db\Exceptions\DbException;

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
     * @return bool
     * @throws DbException|ConfigException
     */
    public function up()
    {
        return $this->exec("/* PUT HERE YOUR SQL */");
    }

    /**
     * @return bool
     * @throws DbException|ConfigException
     */
    public function down()
    {
        return $this->exec("/* PUT HERE YOUR SQL */");
    }
}
