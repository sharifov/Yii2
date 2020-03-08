<?php

use yii\db\Migration;

class m160412_133107_add_row_to_fv_sanatorium_prices extends Migration
{
    public function up()
    {
        $this->addColumn('fv_sanatorium_prices', 'number_people', 'int(11) NOT NULL DEFAULT 1 COMMENT \'Количество человек\'');
    }

    public function down()
    {
        $this->dropColumn('fv_sanatorium_prices', 'number_people');
    }
}
