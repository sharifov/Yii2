<?php

use yii\db\Migration;

class m160219_124608_add_row_to_mdedical_base_group_id extends Migration
{
    public function up()
    {
        $this->addColumn('fv_manual_medical_base', 'group_id', 'int(10) DEFAULT NULL ');
    }

    public function down()
    {
        $this->dropColumn('fv_manual_medical_base', 'group_id');
    }
}
