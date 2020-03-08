<?php

use yii\db\Migration;

class m160414_080637_drop_column_direction_type extends Migration
{
    public $tableName = '{{%company_transfer}}';

    public function safeUp()
    {
        $this->dropColumn($this->tableName, 'direction_type');
    }

    public function safeDown()
    {
        $this->addColumn($this->tableName, 'direction_type', 'ENUM("Return", "One-way") DEFAULT "Return" COMMENT "Направление" ');
    }
}
