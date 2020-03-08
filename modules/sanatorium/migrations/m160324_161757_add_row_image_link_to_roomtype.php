<?php

use yii\db\Migration;

class m160324_161757_add_row_image_link_to_roomtype extends Migration
{
    public function up()
    {
        $this->addColumn('fv_sanatorium_room_type', 'image_link', 'varchar(255) DEFAULT NULL COMMENT\'image_link\'');
    }

    public function down()
    {
        $this->dropColumn('fv_sanatorium_room_type', 'image_link');
    }
}
