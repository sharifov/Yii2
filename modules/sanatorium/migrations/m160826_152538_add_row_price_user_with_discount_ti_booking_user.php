<?php

use yii\db\Migration;

class m160826_152538_add_row_price_user_with_discount_ti_booking_user extends Migration
{
    public function up()
    {
        $this->addColumn('fv_sanatorium_booking_users', 'price_basic_discount', 'decimal(10,2) NOT NULL DEFAULT \'0.00\' COMMENT \'(основная цена (евро) с скидкой)\'');
        $this->addColumn('fv_sanatorium_booking_users', 'price_user_discount', 'decimal(10,2) NOT NULL DEFAULT \'0.00\' COMMENT \'(основная цена с скидкой)\'');
    }

    public function down()
    {
        $this->dropColumn('fv_sanatorium_booking_users', 'price_basic_discount');
        $this->dropColumn('fv_sanatorium_booking_users', 'price_basic_price_user_discountdiscount');
    }

}
