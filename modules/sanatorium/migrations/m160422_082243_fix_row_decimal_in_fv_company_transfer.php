<?php

use yii\db\Migration;

class m160422_082243_fix_row_decimal_in_fv_company_transfer extends Migration
{
    public function up()
    {
        $this->alterColumn('fv_company_transfer', 'price', 'decimal(10,2) NOT NULL DEFAULT \'0.00\' COMMENT \'Цена\'');

    }

    public function down()
    {
        $this->alterColumn('fv_company_transfer', 'price', 'decimal(10,3) NOT NULL DEFAULT \'0.000\' COMMENT \'Цена\'');
    }
}
