<?php

namespace Models\WHMCS;

use Core\ActiveRecordDriver;
use Core\Traits\HasRelationships;

class Invoice extends ActiveRecordDriver
{
    use HasRelationships;

    protected static $connection_name = 'maria-db-whmcs';
    //protected static $_table_name = '{{invoices}}';

    /**
     * @throws \Core\Exceptions\DbException
     */
    public function client()
    {
        return $this->belongsTo(Client::class, 'userid', 'id');
    }
}