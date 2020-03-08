<?php

use yii\db\Migration;

class m160229_112913_add_column_to_company_transfer_distance extends Migration
{
    public function up()
    {
        $this->addColumn('fv_company_transfer', 'distance', 'int(11) NOT NULL DEFAULT 0');
    }

    public function down()
    {
        $this->dropColumn('fv_company_transfer', 'distance');
    }
}
