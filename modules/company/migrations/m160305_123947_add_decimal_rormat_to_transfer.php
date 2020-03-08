<?php

use yii\db\Migration;

class m160305_123947_add_decimal_rormat_to_transfer extends Migration
{
    public function up()
    {
        $this->dropColumn('fv_company_transfer', 'price');
        $this->addColumn('fv_company_transfer', 'price', 'DECIMAL(10,3) NOT NULL DEFAULT 0');
    }

    public function down()
    {
        $this->dropColumn('fv_company_transfer', 'price');
        $this->addColumn('fv_company_transfer', 'price', 'DECIMAL(10,3) NOT NULL DEFAULT 0');


    }
}
