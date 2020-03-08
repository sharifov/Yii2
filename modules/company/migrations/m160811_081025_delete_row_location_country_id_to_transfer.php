<?php

use yii\db\Migration;

class m160811_081025_delete_row_location_country_id_to_transfer extends Migration
{
    public function up()
    {
        $this->dropColumn('fv_company_transfer', 'location_country_id');
    }

    public function down()
    {
        $this->addColumn('fv_company_transfer', 'location_country_id', 'int(11)');
    }
}
