<?php

namespace Db\migrations;

use Core\Exceptions\DbException;
use Db\migrations\tpl\mMain;

class m20230613_084919_contacts extends mMain
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
            ALTER TABLE {{contacts}} ADD COLUMN `created_at` datetime DEFAULT CURRENT_TIMESTAMP; 
        ");
    }

    /**
     * @return false
     * @throws DbException
     */
    public function down()
    {
        return $this->exec("
            ALTER TABLE {{contacts}} DROP COLUMN `created_at`;
        ");
    }
}
