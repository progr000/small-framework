<?php

namespace Db\migrations\tpl;

use Core\App;
use Core\Exceptions\DbException;
use Core\Providers\MigrationSchemaProvider;

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

    /** @var MigrationSchemaProvider */
    protected $Schema;

    /**
     * @throws DbException
     */
    public function __construct()
    {
        if (!static::$connection_name) {
            static::$connection_name = config('databases->default-db-connection-name', 'db-main');
        }

        if (isset(App::$DbInstances[static::$connection_name])) {
            $this->db = App::$DbInstances[static::$connection_name];
            $this->Schema = (new MigrationSchemaProvider())->register($this->db);
        } else {
            throw new DbException("This connection is not initialized correctly", 500);
        }
    }

    /**
     * @param string $queries
`     * @param array $params
     * @return bool
     * @throws DbException
     */
    protected function exec($queries, $params = [])
    {
        $queries_ = explode(';', $queries);
        foreach ($queries_ as $sql) {
            $sql = trim($sql);
            if (!empty($sql)) {
                if (!$this->db->exec($sql, $params)) {
                    return false;
                }
            }
        }

        return true;
    }

    /**
     * @return array|mixed
     */
    public function getErrors()
    {
        return $this->db->getErrors();
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