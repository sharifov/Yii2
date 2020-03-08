<?php

use yii\db\Migration;

class m160223_134016_add_clolumn_to_fv_manual_consultants_sort extends Migration
{
    public function up()
    {
        $this->addColumn('fv_manual_consultants', 'sort', 'int(10) NOT NULL DEFAULT 0');
    }

    public function down()
    {
        $this->dropColumn('fv_manual_consultants', 'sort');
    }
}
