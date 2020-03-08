<?php

use yii\db\Migration;

class m160325_100747_add_row_sanatorium_room_type_id_to_fv_sanatorium_booking_users extends Migration
{
    public function up()
    {
        $this->addColumn('fv_sanatorium_booking_users', 'sanatorium_room_type_id', 'int(11) unsigned NOT NULL');
        $this->addForeignKey('fv_sanatorium_booking_users_basket_fv_sanatorium_room_type', 'fv_sanatorium_booking_users', 'sanatorium_room_type_id', 'fv_sanatorium_room_type', 'id', 'CASCADE');
    }

    public function down()
    {
        $this->dropColumn('fv_sanatorium_booking_users', 'sanatorium_room_type_id');
    }
}
