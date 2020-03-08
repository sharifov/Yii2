<?php

use yii\db\Migration;

class m160428_080251_add_row_search_tittle_for_country extends Migration
{
    public function up()
    {
        $this->addColumn('fv_location_country', 'search_title', 'varchar(255) NOT NULL DEFAULT \'\' COMMENT\'Английское название для поиска на стринице\'');
    }

    public function down()
    {
        $this->dropColumn('fv_location_country', 'search_title');
    }
}
