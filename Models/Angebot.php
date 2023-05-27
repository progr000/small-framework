<?php

namespace Models;

use Core\ActiveRecordDriver;


class Angebot extends ActiveRecordDriver
{
    protected static $_primary_key_field = 'an_id';

    protected static $_table_name = "{{Angebot}}";

    protected static $connection_name = 'weblandAdmin';

}