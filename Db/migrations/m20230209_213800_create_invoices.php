<?php

namespace Db\migrations;

use Core\App;

class m20230209_213800_create_invoices
{
    public function up()
    {
        return App::$db->exec("
            CREATE TABLE IF NOT EXISTS {{invoices}}
            (
                `invoice_id`              int                     NOT NULL AUTO_INCREMENT COMMENT 'internal record id',
                `invoice_amount`          DECIMAL(10, 2) UNSIGNED NOT NULL DEFAULT '0.00' COMMENT 'invoice amount = total sum all records from table {{invoice_products}}',
                `invoice_date`            date                    NOT NULL DEFAULT (CURRENT_DATE) COMMENT 'invoice date',
                `invoice_sent_date`       date                             DEFAULT NULL COMMENT 'date when invoice was sent to user',
                `invoice_sent_remainder1` DATE                             DEFAULT NULL COMMENT 'date when first letter remainder about pay was sent to user',
                `invoice_sent_remainder2` date                             DEFAULT NULL COMMENT 'date when second letter remainder about pay was sent to user',
                `invoice_sent_sms`        date                             DEFAULT NULL COMMENT 'date when sms was sent to user (I think it is last remainder for pay)',
                `invoice_payed_date`      date                             DEFAULT NULL COMMENT 'date when user payed invoice',
                `invoice_payed`           tinyint                 NOT NULL DEFAULT 0 COMMENT 'reserved just in case',
                `invoice_reserved2`       tinyint                          DEFAULT NULL COMMENT 'reserved just in case',
                `invoice_reserved3`       tinyint                          DEFAULT NULL COMMENT 'reserved just in case',
                `id_kunde`                int UNSIGNED COMMENT 'client id',
                `client_company_name`     varchar(35)                      DEFAULT NULL COMMENT 'client\'s company name',
                `client_first_name`       varchar(35)             NOT NULL COMMENT 'client\'s name',
                `client_second_name`      varchar(35)             NOT NULL COMMENT 'client\'s surname',
                `client_email`            varchar(255)            NOT NULL COMMENT 'client\'s email',
                `client_phone`            varchar(20)                      DEFAULT NULL COMMENT 'client\'s phone',
                `client_postcode`         varchar(10)             NOT NULL COMMENT 'client\'s zip-code',
                `client_country`          varchar(40)                      DEFAULT NULL COMMENT 'client\'s country',
                `client_city`             varchar(40)             NOT NULL COMMENT 'client\'s city',
                `client_street`           varchar(40)             NOT NULL COMMENT 'client\'s street',
            
                PRIMARY KEY (`invoice_id`),
                KEY `id_kunde_idx` (`id_kunde`),
                KEY `invoice_sent_date_idx` (`invoice_sent_date`, `invoice_payed`),
                KEY `invoice_sent_remainder1_idx` (`invoice_date`, `invoice_payed`, `invoice_sent_remainder1`),
                KEY `invoice_sent_remainder2_idx` (`invoice_date`, `invoice_payed`, `invoice_sent_remainder2`),
                KEY `invoice_sent_sms_idx` (`invoice_date`, `invoice_payed`, `invoice_sent_sms`),
                KEY `invoice_payed_date_idx` (`invoice_payed_date`)
            # unfortunately table kunde has type MyISAM which not supported foreign keys and transactions
            #     , CONSTRAINT `FK_kunde_to_invoice`
            #         FOREIGN KEY (`id_kunde`)
            #             REFERENCES {{kunde}} (`id_kunde`)
            #             ON DELETE SET NULL
            #             ON UPDATE CASCADE
            ) ENGINE = InnoDB
              COLLATE = 'utf8_general_ci';        
        ");
    }

    public function down()
    {
        return App::$db->exec("
            DROP TABLE IF EXISTS {{invoices}};
        ");
    }
};
