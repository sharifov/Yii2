<?php

use yii\db\Migration;

/**
 * Handles adding status to table `booking`.
 */
class m160603_101321_add_status_to_booking extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->alterColumn('fv_sanatorium_booking',
            'status',
            'enum(\'booked\', \'cancelled\', \'add-manager_one_room\', \'add-manager_all_rooms\') NOT NULL DEFAULT \'booked\'
            COMMENT \'booked - забронирован cancelled - отменен add-manager_one_room - добавлен менеджером 1 комната,  add-manager_all_rooms - добавлен менеджером все номера\'');

    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->alterColumn('fv_sanatorium_booking',
            'status',
            'enum(\'booked\', \'cancelled\', \'add-manager_one_room\', \'add-manager_all_rooms\') NOT NULL DEFAULT \'booked\'
            COMMENT \'booked - забронирован cancelled - отменен add-manager_one_room - добавлен менеджером 1 комната,  add-manager_all_rooms - добавлен менеджером все номера\'');
    }
}
