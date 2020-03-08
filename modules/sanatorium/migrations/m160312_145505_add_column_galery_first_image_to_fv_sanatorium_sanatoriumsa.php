<?php

use yii\db\Migration;

class m160312_145505_add_column_galery_first_image_to_fv_sanatorium_sanatoriumsa extends Migration
{
    public function up()
    {
        $this->addColumn('fv_sanatorium_sanatoriums', 'gallery_first_image', 'varchar(256) DEFAULT \'\' COMMENT \'первое фото в галереи\' ');
    }

    public function down()
    {
        $this->dropColumn('fv_sanatorium_sanatoriums', 'gallery_first_image');
    }
}
