<?php

namespace Db\migrations;

use Core\Contracts\MigrationSchema\Common\SchemaTable;
use Core\Exceptions\DbException;
use Db\migrations\tpl\mMain;

class m20240302_080000_test extends mMain
{
    /**
     * You can put in this var string with name
     * of db-connection from config/databases.php
     * to create/modify/delete table from different database
     * instead default (when this var not set)
     * @var string
     */
    //protected static $connection_name;
    protected static $connection_name = 'sqlite-for-developing';

    /**
     * @return bool
     * @throws DbException
     */
    public function up()
    {
        return $this->Schema->createTable/*IfNotExists*/('{{tesssssssssst}}', function (SchemaTable $table) {
            $table->column('id')->int(8)->primaryKey()->comment('test \' comment')->unsigned()->nullable(false);
            $table->column('user_id')->int()->comment('test foreign');//->unsigned()->nullable(false);
            $table->column('email')->string(50)->unique()->defaultVal('test_email')->nullable(false)->comment('user email')->unique();
            $table->column('name')->char(20);
            $table->column('reserved')->defaultVal('ette')->int();
            $table->column('float_test')->float()->unsigned()->nullable(false)->defaultVal(11.234);
            $table->column('double_test')->double()->unsigned()->nullable(false)->defaultVal(12.567);
            $table->column('decimal_test')->decimal()->unsigned()->nullable(false)->defaultVal(13.891);
            $table->column('bit_test')->bit(4)->unsigned()->nullable(false)->defaultVal(3);
            $table->column('bool_test')->bool()->unsigned()->nullable(false)->defaultVal(true)->index();
            $table->column('text_test')->text()->defaultVal('text')->nullable(false);
            $table->column('blob_test')->blob()->defaultVal('text')->nullable(false);
            $table->column('date_test')->date()->defaultVal('2024-12-05')->nullable(false);
            $table->column('time_test')->time()->defaultVal('22:15:33')->nullable(false);
            $table->column('datetime_test')->datetime()->defaultVal('2024-12-05 22:15:33')->nullable(false);
            $table->column('timestamp_test')->timestamp()->defaultVal('2024-12-05 22:15:33')->nullable(false);
            $table->column('year_test')->year()->defaultVal(2023)->nullable(false);
            $table->column('json_test')->nullable(false)->defaultVal('dddd')->manual_raw('json NOT NULL');
            $table->unique('idx_name', ['name', 'reserved']);
            $table->index('idx_name', 'name');
            $table->index('idx_name2', ['name', 'double_test']);
            $table->foreignKey('idx_foreign_user_id', 'user_id', '{{users}}', 'id', 'SET NULL', 'CASCADE');
        });
    }

    /**
     * @return bool
     * @throws DbException
     */
    public function down()
    {
        return $this->Schema->dropTableIfExists('{{tesssssssssst}}');
    }
}
