<?php

use yii\db\Migration;

class m160512_121437_add_column_whole_stay extends Migration
{

    public $tableName = '{{%sanatorium_rel_treatment_package}}';

    public function safeUp()
    {
        $this->addColumn($this->tableName, 'whole_stay', $this->boolean()->defaultValue(0) . ' COMMENT "Whole stay"');
    }

    public function safeDown()
    {
        $this->dropColumn($this->tableName, 'whole_stay');
    }
}
