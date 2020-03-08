<?php

use yii\db\Migration;

class m160311_102000_add_culumn_manual_room_id_to_fv_sanatorium_discount extends Migration
{
    public function up()
    {
        $this->addColumn('fv_sanatorium_discount', 'manual_room_id', 'int(11) unsigned');
    }

    public function down()
    {
        $this->dropColumn('fv_sanatorium_discount', 'manual_room_id');
    }
}
