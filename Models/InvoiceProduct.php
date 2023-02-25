<?php

namespace Models;

use Core\ActiveRecordDriver;


class InvoiceProduct extends ActiveRecordDriver
{
    protected static $_primary_key_field = 'internal_id';
}