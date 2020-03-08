<?php

use yii\db\Migration;

class m160328_070226_add_column_to_sanatoriums_useful_to_know extends Migration
{
    
    public $tableName = '{{%sanatorium_sanatoriums_lang}}';
    
    public function up()
    {
        $this->addColumn($this->tableName, 'useful_to_know', " text COMMENT 'Важно Знать' ");
    }

    public function down()
    {
        $this->dropColumn($this->tableName, 'useful_to_know');
    }
}
