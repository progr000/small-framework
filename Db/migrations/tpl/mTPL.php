<?php

namespace Db\migrations;

use Core\App;
use Core\Exceptions\DbException;
use PDOStatement;


class __NEW_CLASS_NAME__
{
    /**
     * @return false|PDOStatement
     * @throws DbException
     */
    public function up()
    {
        return App::$db->exec("/* PUT HERE YOUR SQL */");
    }

    /**
     * @return false|PDOStatement
     * @throws DbException
     */
    public function down()
    {
        return App::$db->exec("/* PUT HERE YOUR SQL */");
    }
}
