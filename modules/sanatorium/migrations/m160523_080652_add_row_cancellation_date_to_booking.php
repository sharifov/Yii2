<?php

use yii\db\Migration;

/**
 * Handles adding row_cancellation_date to table `booking`.
 */
class m160523_080652_add_row_cancellation_date_to_booking extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn('fv_sanatorium_booking', 'cancellation_date', ' int(11) unsigned NOT NULL DEFAULT \'0\' COMMENT \'дата анулирования бронирования\'');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropColumn('fv_sanatorium_booking', 'cancellation_date');
    }
}
