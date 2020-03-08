<?php

use yii\db\Migration;

/**
 * Handles adding price_with_discount to table `fv_sanatorium_basket`.
 */
class m160513_144919_add_price_with_discount_to_fv_sanatorium_basket extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn('fv_sanatorium_booking_basket', 'price_basic_discount', 'decimal(10,2) NOT NULL DEFAULT \'0.00\' COMMENT \'(основная цена c скидкой)\'');
        $this->addColumn('fv_sanatorium_booking_basket', 'price_user_discount', 'decimal(10,2) NOT NULL DEFAULT \'0.00\' COMMENT \'(валюта клиента c скидкой)\'');

    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropColumn('fv_sanatorium_booking_basket', 'price_basic_discount');
        $this->dropColumn('fv_sanatorium_booking_basket', 'price_user_discount');

    }
}
