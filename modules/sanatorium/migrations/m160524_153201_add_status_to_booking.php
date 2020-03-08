<?php

use yii\db\Migration;

/**
 * Handles adding status to table `booking`.
 */
class m160524_153201_add_status_to_booking extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {

        $this->alterColumn('fv_sanatorium_booking',
            'status',
            'enum(\'booked\', \'cancelled\', \'add-manager\') NOT NULL DEFAULT \'booked\' COMMENT \'booked - забронирован cancelled - отменен add-manager - добавлен менеджером\'');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->alterColumn('fv_sanatorium_booking',
            'status',
            'enum(\'booked\', \'cancelled\') NOT NULL DEFAULT \'booked\' COMMENT \'booked - забронирован cancelled - отменен \'');

    }
}
