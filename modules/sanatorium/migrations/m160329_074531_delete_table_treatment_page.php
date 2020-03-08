<?php

use yii\db\Migration;

class m160329_074531_delete_table_treatment_page extends Migration
{
    public function up()
    {
        $this->dropTable('fv_sanatorium_treatment_package_lang');
        $this->dropTable('fv_sanatorium_treatment_package');

    }

    public function down()
    {
        $this->createTable('fv_sanatorium_treatment_package', 'id int(11)');
        $this->createTable('fv_sanatorium_treatment_package_lang', 'id int(11)');
    }
}
