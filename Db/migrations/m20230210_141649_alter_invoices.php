<?php

namespace Db\migrations;

use Core\App;
use Core\Exceptions\DbException;


class m20230210_141649_alter_invoices
{
    /**
     * @return bool
     * @throws DbException
     */
    public function up()
    {
        $res2 = App::$db->exec("
            ALTER TABLE {{invoices}} RENAME COLUMN invoice_reserved2 TO invoice_lang
        ");
        $res1 = App::$db->exec("
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
        $res2 = App::$db->exec("
            ALTER TABLE {{invoices}} RENAME COLUMN invoice_lang TO invoice_reserved2 
        ");
        $res1 = App::$db->exec("
            ALTER TABLE {{invoices}} MODIFY COLUMN invoice_reserved2 tinyint NULL COMMENT 'reserved just in case'
        ");

        return $res1 && $res2;
    }
}
