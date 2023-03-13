<?php

namespace Db\migrations;

use Core\App;
use Core\Exceptions\DbException;
use PDOStatement;

class m20230209_220000_create_invoice_products
{
    /**
     * @return false|PDOStatement
     * @throws DbException
     */
    public function up()
    {
        return App::$db->exec("
            CREATE TABLE IF NOT EXISTS {{invoice_products}}
            (
                `internal_id`       int                     NOT NULL AUTO_INCREMENT COMMENT 'internal id for table for convenient manipulation with the record',
                `invoice_id`        int                     NOT NULL COMMENT 'id from {{invoices.invoice_id}} (FK)',
                `period_start`      date                    NOT NULL COMMENT 'bestell_datum from {{bestellung}} or {{bestellung_spezial}} or {{bestellung_ssl}}',
                `period_end`        date                    NOT NULL COMMENT 'period_start + 1YEAR',
                `product_name`      varchar(50)             NOT NULL COMMENT 'get it from tables {{abotyp}} or {{spezial}} or {{ssl}}',
                `product_count`     tinyint UNSIGNED        NOT NULL DEFAULT 1 COMMENT 'think, it always equal to 1, but may be sometimes will be useful',
                `product_amount`    DECIMAL(10, 2) UNSIGNED NOT NULL DEFAULT '0.00' COMMENT 'preis from {{bestellung}} or {{bestellung_spezial}} or {{bestellung_ssl}} (for ssl I think from {{ssl}})',
                `product_tax`       decimal(10, 2) UNSIGNED NOT NULL DEFAULT '0.00' COMMENT '??? (example 7.7%) where can I get it',
            
                `product_table`     varchar(50)             NOT NULL COMMENT 'table name from which the product received {{bestellung}} or {{bestellung_spezial}} or {{bestellung_ssl}}',
                `product_id`        int                     NOT NULL COMMENT 'id_bestellung or id_bestellung_spezial or id_bestellung_ssl from table product_table',
                `product_abo_table` varchar(50)             NOT NULL COMMENT 'table name which defined the product {{abotyp}} or {{spezial}} or {{ssl}}',
                `product_abo_id`    int                     NOT NULL COMMENT 'id from table id_abo or id_spezial or id_ssl',
                `product_prefix`    varchar(50)             NOT NULL COMMENT 'prefix from tables {{abotyp}} or {{spezial}} or {{ssl}}',
            
                PRIMARY KEY (`internal_id`),
                CONSTRAINT `FK_products_to_invoice`
                    FOREIGN KEY (`invoice_id`)
                        REFERENCES {{invoices}} (`invoice_id`)
                        ON DELETE CASCADE
                        ON UPDATE CASCADE
            ) ENGINE = InnoDB
              COLLATE = 'utf8_general_ci';                  
        ");
    }

    /**
     * @return false|PDOStatement
     * @throws DbException
     */
    public function down()
    {
        return App::$db->exec("
            DROP TABLE IF EXISTS {{invoice_products}};
        ");
    }
};
