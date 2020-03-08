<?php

use yii\db\Migration;

class m160305_122847_add_columt_to_fv_location_currency_course extends Migration
{
    public function up()
    {
        $this->addColumn('fv_location_currency', 'course', 'DECIMAL(10,3) NOT NULL DEFAULT 1');
    }

    public function down()
    {
        $this->dropColumn('fv_location_currency', 'course');
    }
}
