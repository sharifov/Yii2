<?php

use yii\db\Migration;

class m160314_093626_add_col_image_link_to_fv_sanatorium_treatment_package extends Migration
{
    public function up()
    {
        $this->addColumn('fv_sanatorium_treatment_package', 'image_link', 'varchar(255) NOT NULL COMMENT \'image_link\' ');
    }

    public function down()
    {
        $this->dropColumn('fv_sanatorium_treatment_package', 'image_link');
    }
}
