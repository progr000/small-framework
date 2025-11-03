<?php

namespace Models\WHMCS;

use Maksym\Db\Exceptions\DbException;
use Maksym\Config\ConfigException;
use Maksym\Db\ActiveRecordDriver;
use Maksym\Db\Traits\HasRelationships;

class Client extends ActiveRecordDriver
{
    use HasRelationships;

    protected static $connection_name = 'maria-db-whmcs';
    //protected static $_table_name = '{{clients}}';

    /**
     * @return ActiveRecordDriver|mixed|null
     * @throws ConfigException
     * @throws DbException
     */
    public function currency()
    {
        return $this->hasOne(Currency::class, 'id', 'currency');
    }

    /**
     * @return Invoice[]|false|string
     * @throws ConfigException
     * @throws DbException
     */
    public function invoices()
    {
        return $this->hasMany(Invoice::class, 'userid', 'id');
    }
}