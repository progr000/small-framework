<?php

namespace Db\migrations;

use Core\App;


class m20230214_142027_alter_invoices
{
    /**
     * @return false|\PDOStatement
     */
    public function up()
    {
        $first = App::$db->exec("
            ALTER TABLE {{invoices}}
                ADD COLUMN invoice_unique_hash varchar(40) NOT NULL COMMENT 'Hash to check that invoice is unique in DB' AFTER invoice_id;

        ");
        if (!$first) return false;

        $second = App::$db->exec("UPDATE {{invoices}} SET invoice_unique_hash = sha1(concat(invoice_id, id_kunde, invoice_date, invoice_amount)) WHERE 1;");
        if (!$second) return false;

        return App::$db->exec("
            ALTER TABLE {{invoices}}
                ADD UNIQUE INDEX invoice_unique_hash_idx (invoice_unique_hash);
        ");
    }

    /**
     * @return false|\PDOStatement
     */
    public function down()
    {
        return App::$db->exec("
            ALTER TABLE {{invoices}} 
                DROP INDEX invoice_unique_hash_idx,
                DROP COLUMN invoice_unique_hash;
        ");
    }
}
