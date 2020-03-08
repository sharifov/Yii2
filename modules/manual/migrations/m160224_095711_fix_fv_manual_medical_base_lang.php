<?php

use yii\db\Migration;

class m160224_095711_fix_fv_manual_medical_base_lang extends Migration
{
    public function up()
    {
        $this->alterColumn('fv_manual_medical_base_lang', 'lang', 'varchar(5) NOT NULL');
    }

    public function down()
    {
        $this->alterColumn('fv_manual_medical_base_lang', 'lang', 'varchar(5) NOT NULL');
    }
}
