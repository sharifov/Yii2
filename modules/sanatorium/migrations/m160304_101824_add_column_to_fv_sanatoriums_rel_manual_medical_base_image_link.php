<?php

use yii\db\Migration;

class m160304_101824_add_column_to_fv_sanatoriums_rel_manual_medical_base_image_link extends Migration
{
    public function up()
    {
        $this->addColumn('fv_sanatoriums_rel_manual_medical_base', 'image_link', 'varchar(255) DEFAULT NULL COMMENT \'image_link\'');
    }

    public function down()
    {
        $this->dropColumn('fv_sanatoriums_rel_manual_medical_base', 'image_link');
    }
}
