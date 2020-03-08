<?php

use yii\db\Migration;

class m160301_083230_add_col_to_city_on_main extends Migration
{
    public function up()
    {
        $this->addColumn('fv_location_city', 'on_main', 'int(1) NOT NULL DEFAULT 0');
    }

    public function down()
    {
        $this->dropColumn('fv_location_city', 'on_main');
    }
}
