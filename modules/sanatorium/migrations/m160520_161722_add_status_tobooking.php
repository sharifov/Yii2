<?php

use yii\db\Migration;

class m160520_161722_add_status_tobooking extends Migration
{
    public function up()
    {
        $this->addColumn('fv_sanatorium_booking', 'status', 'enum(\'booked\',\'cancelled\') NOT NULL DEFAULT \'booked\' COMMENT \'booked - забронирован cancelled - отменен \'');

    }

    public function down()
    {
        $this->dropColumn('fv_sanatorium_booking', 'status');
    }
}
