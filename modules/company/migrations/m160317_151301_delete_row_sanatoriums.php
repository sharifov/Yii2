<?php

use yii\db\Migration;

class m160317_151301_delete_row_sanatoriums extends Migration
{
    public function up()
    {
        $this->dropColumn('fv_company_transfer', 'sanatoriums_id');
    }

    public function down()
    {
        $this->addColumn('fv_company_transfer', 'sanatoriums_id', 'int(11) unsigned NOT NULL COMMENT \'санаторий\'');
    }
}
