<?php

use yii\db\Migration;

/**
 * Handles adding sanatorium_price to table `fv_sanatorium_booking`.
 */
class m160829_145824_add_sanatorium_price_to_fv_sanatorium_booking extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn('fv_sanatorium_booking', 'total_price_sanatorium', 'decimal(10,2) NOT NULL DEFAULT \'0.00\' COMMENT \'(основная цена (евро) с скидкой)\'');
        $this->addColumn('fv_sanatorium_booking', 'total_price_sanatorium_discount', 'decimal(10,2) NOT NULL DEFAULT \'0.00\' COMMENT \'(основная цена с скидкой)\'');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropColumn('fv_sanatorium_booking', 'total_price_sanatorium');
        $this->dropColumn('fv_sanatorium_booking', 'total_price_sanatorium_discount');
    }
}
