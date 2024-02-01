<?php

namespace Models\WHMCS;

use Core\ActiveRecordDriver;

class Currency extends ActiveRecordDriver
{
    protected static $connection_name = 'maria-db-whmcs';
    protected static $_table_name = '{{currencies}}';

    /**
     * @return array
     * @throws \Core\Exceptions\DbException
     */
    public static function primaryKeyasArrayKey()
    {
        $ret = [];
        $currencies = self::find()->all();
        foreach ($currencies as $v) {
            $ret[$v->id] = $v;
        }
        return $ret;
    }
}