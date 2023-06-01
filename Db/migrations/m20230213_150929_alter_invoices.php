<?php

namespace Db\migrations;

use Core\Exceptions\DbException;
use Db\migrations\tpl\mMain;
use PDOStatement;

class m20230213_150929_alter_invoices extends mMain
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
        return $this->db->exec("
            ALTER TABLE {{invoices}} 
                ADD COLUMN mailer_last_full_answer tinytext DEFAULT NULL AFTER invoice_reserved3,
                ADD COLUMN mailer_last_queue_id varchar(25) DEFAULT NULL AFTER mailer_last_full_answer,
                ADD COLUMN mailer_last_status varchar(15) DEFAULT NULL AFTER mailer_last_queue_id,
                ADD INDEX mailer_last_queue_id_idx (mailer_last_queue_id),
                ADD INDEX mailer_last_status_idx (mailer_last_status);
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
                DROP INDEX mailer_last_status_idx,
                DROP INDEX mailer_last_queue_id_idx,
                DROP COLUMN mailer_last_full_answer,
                DROP COLUMN mailer_last_queue_id,
                DROP COLUMN mailer_last_status;        
        ");
    }
}
