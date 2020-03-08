<?php

use yii\db\Migration;

class m160312_145927_add_column_image_main_to_fv_sanatorium_sanatoriumsa extends Migration
{
    public function up()
    {
        $this->addColumn('fv_sanatorium_sanatoriums', 'image_main', 'varchar(256) DEFAULT \'\' COMMENT \'главное фото (на главную стр.)\' ');
    }

    public function down()
    {
        $this->dropColumn('fv_sanatorium_sanatoriums', 'image_main');
    }
}
