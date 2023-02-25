<?php

namespace Db\migrations;

use Core\App;


class m20230213_150929_alter_invoices
{
    /**
     * @return false|\PDOStatement
     */
    public function up()
    {
        return App::$db->exec("
            ALTER TABLE {{invoices}} 
                ADD COLUMN mailer_last_full_answer tinytext DEFAULT NULL AFTER invoice_reserved3,
                ADD COLUMN mailer_last_queue_id varchar(25) DEFAULT NULL AFTER mailer_last_full_answer,
                ADD COLUMN mailer_last_status varchar(15) DEFAULT NULL AFTER mailer_last_queue_id,
                ADD INDEX mailer_last_queue_id_idx (mailer_last_queue_id),
                ADD INDEX mailer_last_status_idx (mailer_last_status);
        ");
    }

    /**
     * @return false|\PDOStatement
     */
    public function down()
    {
        return App::$db->exec("
            ALTER TABLE {{invoices}} 
                DROP INDEX mailer_last_status_idx,
                DROP INDEX mailer_last_queue_id_idx,
                DROP COLUMN mailer_last_full_answer,
                DROP COLUMN mailer_last_queue_id,
                DROP COLUMN mailer_last_status;        
        ");
    }
}
