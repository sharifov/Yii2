<?php

use yii\db\Migration;

/**
 * Handles adding row_price_sanatorium to table `price`.
 */
class m160526_072753_add_row_price_sanatorium_to_price extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn('fv_sanatorium_prices', 'price_euro', 'decimal(10,2) NOT NULL DEFAULT \'0.00\' COMMENT \'Цена в валюте санатория\'');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropColumn('fv_sanatorium_prices', 'price_euro');
    }
}
