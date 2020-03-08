<?php

use yii\db\Migration;

class m160325_134520_add_col_recalculated_to_fv_sanatorium_treatment_package extends Migration
{
    public function up()
    {
        $this->addColumn('fv_sanatorium_treatment_package', 'recalculated', ' enum(\'0\',\'1\') NOT NULL DEFAULT \'0\' COMMENT \'Пересчитывать?\' ');
    }

    public function down()
    {
        $this->dropColumn('fv_sanatorium_treatment_package', 'recalculated');
    }
}
