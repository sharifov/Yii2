<?php

use yii\db\Migration;

class m160630_105711_add_row_discount_price_fv_sanatorium_booking extends Migration
{
    public function up()
    {
        $this->addColumn('fv_sanatorium_booking', 'total_price_basic_discount' ,'decimal(10,2) NOT NULL DEFAULT \'0.00\' COMMENT \'(основная цена c скидкой)\'');
        $this->addColumn('fv_sanatorium_booking', 'total_price_user_discount' ,'decimal(10,2) NOT NULL DEFAULT \'0.00\' COMMENT \'(основная цена c скидкой)\'');
    }

    public function down()
    {
        $this->dropColumn('fv_sanatorium_booking', 'total_price_basic_discount');
        $this->dropColumn('fv_sanatorium_booking', 'total_price_user_discount');
    }

}
