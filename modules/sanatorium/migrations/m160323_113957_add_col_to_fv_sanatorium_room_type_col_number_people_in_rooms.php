<?php

use yii\db\Migration;

class m160323_113957_add_col_to_fv_sanatorium_room_type_col_number_people_in_rooms extends Migration
{
    public function up()
    {
        $this->addColumn('fv_sanatorium_room_type', 'number_people_in_rooms', 'int(11) NOT NULL DEFAULT 0  COMMENT\'Колличество человек в номере\'');
    }

    public function down()
    {
        $this->dropColumn('fv_sanatorium_room_type', 'number_people_in_rooms');
    }
}
