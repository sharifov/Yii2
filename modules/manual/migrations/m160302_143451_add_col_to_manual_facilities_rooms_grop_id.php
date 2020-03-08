<?php

use yii\db\Migration;

class m160302_143451_add_col_to_manual_facilities_rooms_grop_id extends Migration
{
    public function up()
    {
        $this->addColumn('fv_manual_facilities_rooms', 'group_id', 'int(11) NOT NULL DEFAULT 0');
        $this->dropColumn('fv_manual_facilities_rooms', 'sort');
    }

    public function down()
    {
        $this->dropColumn('fv_manual_facilities_rooms', 'group_id');
        $this->addColumn('fv_manual_facilities_rooms', 'sort', 'int(11) NOT NULL DEFAULT 0');
    }
}
