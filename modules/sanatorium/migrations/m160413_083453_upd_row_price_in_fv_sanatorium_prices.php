<?php

use yii\db\Migration;

class m160413_083453_upd_row_price_in_fv_sanatorium_prices extends Migration
{
    public function up()
    {
        $this->dropColumn('fv_sanatorium_prices', 'type_food');
        $this->addColumn('fv_sanatorium_prices', 'type_food', ' enum(\'FBT\',\'HBT\', \'HB\',\'FB\') NOT NULL DEFAULT \'FBT\' COMMENT \'Тип питания\'');
    }

    public function down()
    {
//        $this->addColumn('fv_sanatorium_prices', 'type_food', ' enum(\'FBT\',\'HBT\', \'HB\',\'FB\') NOT NULL DEFAULT \'FBT\' COMMENT \'Тип питания\'');
    }

}
