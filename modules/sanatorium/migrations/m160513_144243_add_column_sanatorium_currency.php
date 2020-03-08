<?php

use yii\db\Migration;

class m160513_144243_add_column_sanatorium_currency extends Migration
{

    public $tableName = '{{%sanatorium_sanatoriums_lang}}';

    public function safeUp()
    {
        $this->addColumn($this->tableName, 'sanatorium_currency', $this->string()->defaultValue(null) . ' COMMENT "Валюта санатория"');
    }

    public function safeDown()
    {
        $this->dropColumn($this->tableName, 'sanatorium_currency');
    }

}
