<?php

use yii\db\Migration;

class m160229_144352_add_column_to_manual_medicalbase_content extends Migration
{
    public function up()
    {
        $this->addColumn('fv_manual_medical_base_lang', 'content', 'varchar(2024) NOT NULL DEFAULT ""');
        $this->addColumn('fv_manual_medical_base', 'image_link', 'varchar(255) NOT NULL DEFAULT ""');
        $this->addColumn('fv_manual_medical_base', 'position', 'int(11) NOT NULL DEFAULT 0');

    }

    public function down()
    {
        $this->dropColumn('fv_manual_medical_base_lang', 'content');
        $this->dropColumn('fv_manual_medical_base', 'image_link');
        $this->dropColumn('fv_manual_medical_base', 'position');
    }
}
