<?php

use yii\db\Migration;

class m160407_070843_add_column_columns_to_countries_widget extends Migration
{

    /**
     * Table name
     * @var string
     */
    public $tableName = '{{%widget_countries}}';

    public function up()
    {
        $this->addColumn($this->tableName, 'columns', 'enum("1 column","2 column","3 column") NOT NULL DEFAULT "1 column" COMMENT "Количество колонок"');
    }

    public function down()
    {
        $this->dropColumn($this->tableName, 'columns');
    }
}
