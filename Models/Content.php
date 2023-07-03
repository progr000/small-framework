<?php

namespace Models;

use Core\ActiveRecordDriver;
use Core\Exceptions\DbException;

/**
 * Class User
 * @package Models
 * @property int $id
 * @property string $key
 * @property string $value
 */
class Content extends ActiveRecordDriver
{
    //protected static $connection_name = 'mysql-for-developing';

    /**
     * @throws DbException
     */
    public static function putIntoSessionAllContent()
    {
        if (!session('content-params')) {
            $data = [];
            /** @var self[] $records */
            $records = self::findAll();
            if ($records) {
                foreach ($records as $record) {
                    $data[$record->key] = $record->value;
                }
            }
            session(['content-params' => $data]);
        }
    }

    /**
     * @param $key
     * @return string
     */
    public static function get($key, $default = "")
    {
        $data = session('content-params', []);
        if (isset($data[$key])) {
            return $data[$key];
        } else {
            try {
                $try = self::findOne(['key' => $key]);
                if ($try) {
                    $data[$key] = $try->value;
                    session(['content-params' => $data]);
                    return $data[$key];
                }
            } catch (\Exception $e) {
                return "";
            }
        }

        return $default;
    }
}