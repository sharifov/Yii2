<?php

use yii\db\Migration;

class m160301_112201_del_column_in_locatoon_country extends Migration
{
    public function up()
    {
        $this->dropColumn('fv_location_country', 'on_main');
        $this->dropColumn('fv_location_city', 'on_main');
    }

    public function down()
    {
        $this->addColumn('fv_location_country', 'on_main', 'int(1) NOT NULL DEFAULT 0');
        $this->addColumn('fv_location_city', 'on_main', 'int(1) NOT NULL DEFAULT 0');
    }

}
