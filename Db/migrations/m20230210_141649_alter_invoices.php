<?php

namespace Db\migrations;

use Core\Exceptions\DbException;
use Db\migrations\tpl\mMain;

class m20230210_141649_alter_invoices extends mMain
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
     * @throws DbException
     */
    public function up()
    {
        $res2 = $this->db->exec("
            ALTER TABLE {{invoices}} RENAME COLUMN invoice_reserved2 TO invoice_lang
        ");
        $res1 = $this->db->exec("
            ALTER TABLE {{invoices}} MODIFY COLUMN invoice_lang varchar(4) NOT NULL DEFAULT 'de' COMMENT 'invoice language'
        ");

        return $res1 && $res2;
    }

    /**
     * @return bool
     * @throws DbException
     */
    public function down()
    {
        $res2 = $this->db->exec("
            ALTER TABLE {{invoices}} RENAME COLUMN invoice_lang TO invoice_reserved2 
        ");
        $res1 = $this->db->exec("
            ALTER TABLE {{invoices}} MODIFY COLUMN invoice_reserved2 tinyint NULL COMMENT 'reserved just in case'
        ");

        return $res1 && $res2;
    }
}
