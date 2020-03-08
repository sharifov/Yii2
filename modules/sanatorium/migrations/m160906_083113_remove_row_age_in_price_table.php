<?php

use yii\db\Migration;

class m160906_083113_remove_row_age_in_price_table extends Migration
{
    public function up()
    {
        $this->dropColumn('fv_sanatorium_prices', 'age');
    }

    public function down()
    {
        $this->addColumn('fv_sanatorium_prices', 'age', 'varchar(255)');
    }
}
