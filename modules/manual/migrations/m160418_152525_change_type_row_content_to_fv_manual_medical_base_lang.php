<?php

use yii\db\Migration;

class m160418_152525_change_type_row_content_to_fv_manual_medical_base_lang extends Migration
{
    public function up()
    {
        $this->alterColumn('fv_manual_medical_base_lang', 'content', 'text COMMENT\'content\'');

    }

    public function down()
    {
        $this->alterColumn('fv_manual_medical_base_lang', 'content', 'varchar(255) NOT NULL COMMENT\'content\'');
    }
}
