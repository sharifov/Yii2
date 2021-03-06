<?php

use yii\db\Migration;

class m160414_143005_add_column_direction_type extends Migration
{
    public $tableName = '{{%company_transfer}}';

    public function safeUp()
    {
        $this->addColumn($this->tableName, 'direction_type', 'ENUM("Return", "One-way") DEFAULT "Return" COMMENT "Направление" ');
    }

    public function safeDown()
    {
        $this->dropColumn($this->tableName, 'direction_type');
    }
}
