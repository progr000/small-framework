<?php

namespace Models\WHMCS;

use Maksym\Db\Exceptions\DbException;
use Maksym\Config\ConfigException;
use Maksym\Db\ActiveRecordDriver;
use Maksym\Db\Traits\HasRelationships;

class Invoice extends ActiveRecordDriver
{
    use HasRelationships;

    protected static $connection_name = 'maria-db-whmcs';
    //protected static $_table_name = '{{invoices}}';

    /**
     * @return ActiveRecordDriver|mixed|null
     * @throws ConfigException
     * @throws DbException
     */
    public function client()
    {
        return $this->belongsTo(Client::class, 'userid', 'id');
    }
}