<?php

use yii\db\Migration;

class m160615_063929_add_column_company_transfer extends Migration
{
    public $tableName = '{{%company_transfer}}';
    
    public function safeUp()
    {
        $this->addColumn($this->tableName, 'pass_number_min', $this->integer()->notNull()->defaultValue(1) . ' COMMENT "Кол-во пассажиров MIN"');
        $this->addColumn($this->tableName, 'pass_number_max', $this->integer()->notNull()->defaultValue(3) . ' COMMENT "Кол-во пассажиров MAX"');
    }
    public function safeDown()
    {
        $this->dropColumn($this->tableName, 'pass_number_min');
        $this->dropColumn($this->tableName, 'pass_number_max');
    }
}
