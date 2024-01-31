<?php

namespace Models\WHMCS;

use Core\ActiveRecordDriver;
use Core\Traits\HasRelationships;

class Client extends ActiveRecordDriver
{
    use HasRelationships;

    protected static $connection_name = 'maria-db-whmcs';
    //protected static $_table_name = '{{clients}}';

    /**
     * @throws \Core\Exceptions\DbException
     */
    public function currency()
    {
        return $this->hasOne(Currency::class, 'id', 'currency');
    }
}