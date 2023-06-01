<?php

namespace Db\migrations\tpl;

use Core\App;
use Core\Exceptions\DbException;

abstract class mMain
{
    /**
     * You can put in this var string with name
     * of db-connection from config/databases.php
     * to create/modify/delete table from different database
     * instead default (when this var not set)
     * @var string
     */
    protected static $connection_name;

    /** @var \Core\DbDriver */
    protected $db;

    /**
     * @throws DbException
     */
    public function __construct()
    {
        if (!static::$connection_name) {
            static::$connection_name = isset(App::$config->get('databases', [])['default-db-connection-name'])
                ? App::$config->get('databases', [])['default-db-connection-name']
                : 'db-main';
        }

        if (isset(App::$DbInstances[static::$connection_name])) {
            $this->db = App::$DbInstances[static::$connection_name];
        } else {
            throw new DbException("This connection is not initialized correctly", 500);
        }
    }

    /**
     * @return mixed
     */
    abstract public function up();

    /**
     * @return mixed
     */
    abstract public function down();
}