<?php

use yii\db\Migration;

/**
 * Handles adding sanatorium_price to table `fv_sanatorium_booking_users`.
 */
class m160829_150821_add_sanatorium_price_to_fv_sanatorium_booking_users extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn('fv_sanatorium_booking_users', 'price_sanatorium', 'decimal(10,2) NOT NULL DEFAULT \'0.00\' COMMENT \'(основная цена (евро) с скидкой)\'');
        $this->addColumn('fv_sanatorium_booking_users', 'price_sanatorium_discount', 'decimal(10,2) NOT NULL DEFAULT \'0.00\' COMMENT \'(основная цена с скидкой)\'');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropColumn('fv_sanatorium_booking_users', 'price_sanatorium');
        $this->dropColumn('fv_sanatorium_booking_users', 'price_sanatorium_discount');
    }
}
