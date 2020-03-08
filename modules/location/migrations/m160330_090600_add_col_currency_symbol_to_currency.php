<?php

use yii\db\Migration;

class m160330_090600_add_col_currency_symbol_to_currency extends Migration
{
    public function up()
    {
        $this->addColumn('fv_location_currency', 'currency_symbol', 'varchar(100) NOT NULL DEFAULT \'\' COMMENT\' символ валюты \'');
    }

    public function down()
    {
        $this->dropColumn('fv_location_currency', 'currency_symbol');
    }
}
