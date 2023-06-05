<?php

namespace Db\migrations;

use Core\Exceptions\DbException;
use Db\migrations\tpl\mMain;
use PDOStatement;

class m20230605_115620_tests_for_pg extends mMain
{
    /**
     * You can put in this var string with name
     * of db-connection from config/databases.php
     * to create/modify/delete table from different database
     * instead default (when this var not set)
     * @var string
     */
    protected static $connection_name = 'postgres-for-developing';

    /**
     * @return false|PDOStatement
     * @throws DbException
     */
    public function up()
    {
        return $this->exec("
            CREATE SEQUENCE tests_for_pg_id_seq
                INCREMENT 1
                START 1
                MINVALUE 1
                MAXVALUE 9223372036854775807
                CACHE 1;
         
            CREATE TABLE {{tests_for_pg}}
            (
                id       BIGINT PRIMARY KEY     NOT NULL DEFAULT nextval('tests_for_pg_id_seq'::regclass),
                amount   NUMERIC(10, 2)         NOT NULL DEFAULT 0.00,
                email    CHARACTER VARYING(35)           DEFAULT NULL,
                name     CHARACTER VARYING(35)  NOT NULL
            ) WITH (
                OIDS = FALSE
            )
            TABLESPACE pg_default;
        
            CREATE UNIQUE INDEX email_idx
                ON {{tests_for_pg}} USING BTREE (email);
        ");
    }

    /**
     * @return false|PDOStatement
     * @throws DbException
     */
    public function down()
    {
        return $this->exec("
            DROP TABLE IF EXISTS {{tests_for_pg}};
            DROP SEQUENCE IF EXISTS tests_for_pg_id_seq;     
        ");
    }
}
