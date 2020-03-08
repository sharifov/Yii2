<?php

use yii\db\Migration;

class m160303_085206_fix_table_fv_manual_areas_treatment_position extends Migration
{
    public function up()
    {
        $this->dropColumn('fv_manual_areas_treatment', 'sort');
        $this->addColumn('fv_manual_areas_treatment', 'position', ' int(11) NOT NULL DEFAULT 0');
    }

    public function down()
    {
        $this->addColumn('fv_manual_areas_treatment', 'sort', ' int(11) NOT NULL DEFAULT 0');
        $this->dropColumn('fv_manual_areas_treatment', 'position');
    }

}
