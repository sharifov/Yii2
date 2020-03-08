<?php

use yii\db\Migration;

class m160329_101122_add_column_status_to_comments extends Migration
{

    /**
     * @var string table name
     */
    public $tableName = '{{%sanatorium_comments}}';

    public function up()
    {
        $this->addColumn($this->tableName, 'status', 'enum("sent","viewed","completed") NOT NULL DEFAULT "sent" COMMENT "Статус комментария"');
    }

    public function down()
    {
        $this->dropColumn($this->tableName, 'status');
    }
}
