<?php

namespace Db\migrations;

use Core\Exceptions\DbException;
use Db\migrations\tpl\mMain;
use PDOStatement;

class m20230214_142027_alter_invoices extends mMain
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
        $first = $this->db->exec("
            ALTER TABLE {{invoices}}
                ADD COLUMN invoice_unique_hash varchar(40) NOT NULL COMMENT 'Hash to check that invoice is unique in DB' AFTER invoice_id;

        ");
        if (!$first) return false;

        $second = $this->db->exec("UPDATE {{invoices}} SET invoice_unique_hash = sha1(concat(invoice_id, id_kunde, invoice_date, invoice_amount)) WHERE 1;");
        if (!$second) return false;

        return $this->db->exec("
            ALTER TABLE {{invoices}}
                ADD UNIQUE INDEX invoice_unique_hash_idx (invoice_unique_hash);
        ");
    }

    /**
     * @return false|PDOStatement
     * @throws DbException
     */
    public function down()
    {
        return $this->db->exec("
            ALTER TABLE {{invoices}} 
                DROP INDEX invoice_unique_hash_idx,
                DROP COLUMN invoice_unique_hash;
        ");
    }
}
