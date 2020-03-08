<?php

use yii\db\Migration;

class m160422_081914_fix_row_decimal_in_san_price extends Migration
{
    public function up()
    {
        $this->alterColumn('fv_sanatorium_prices', 'price', 'decimal(10,2) NOT NULL DEFAULT \'0.000\' COMMENT \'Цена\'');

    }

    public function down()
    {
        $this->alterColumn('fv_sanatorium_prices', 'price', 'decimal(10,3) NOT NULL DEFAULT \'0.000\' COMMENT \'Цена\'');
    }

}
