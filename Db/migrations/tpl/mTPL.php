<?php

namespace Db\migrations;

use Core\App;


class __NEW_CLASS_NAME__
{
    /**
     * @return false|\PDOStatement
     */
    public function up()
    {
        return App::$db->exec("/* PUT HERE YOUR SQL */");
    }

    /**
     * @return false|\PDOStatement
     */
    public function down()
    {
        return App::$db->exec("/* PUT HERE YOUR SQL */");
    }
}
