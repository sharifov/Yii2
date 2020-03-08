<?php

use yii\db\Migration;

/**
 * Handles adding row_price to table `booking_user_sanatorium`.
 */
class m160511_153757_add_row_price_to_booking_user_sanatorium extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn('fv_sanatorium_booking_users', 'price_basic', 'decimal(10,2) NOT NULL DEFAULT \'0.00\' COMMENT \'(основная цена)\'  ');
        $this->addColumn('fv_sanatorium_booking_users', 'price_user', 'decimal(10,2) NOT NULL DEFAULT \'0.00\' COMMENT \'(основная цена)\'  ');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropColumn('fv_sanatorium_booking_users', 'price_basic');
        $this->dropColumn('fv_sanatorium_booking_users', 'price_user');
    }
}
