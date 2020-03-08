<?php

use yii\db\Migration;

class m160223_115730_rename_table_fv_sanatoriums_rel_manual_medical_base extends Migration
{
    public function up()
    {
        $this->execute("
            RENAME TABLE `fv_sanatorium_sanatoriums_many_to_many_manual_medical_base` TO `fv_sanatoriums_rel_manual_medical_base`;
        ");

    }

    public function down()
    {
        $this->execute("
            RENAME TABLE `fv_sanatoriums_rel_manual_medical_base` TO   `fv_sanatorium_sanatoriums_many_to_many_manual_medical_base`;
        ");
    }
}
