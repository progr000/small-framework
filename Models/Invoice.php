<?php

namespace Models;

use Core\ActiveRecordDriver;


class Invoice extends ActiveRecordDriver
{
    protected static $_primary_key_field = 'invoice_id';

    protected static $connection_name = 'mysql-for-developing';


}