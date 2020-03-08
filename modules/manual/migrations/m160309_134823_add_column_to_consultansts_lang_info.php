<?php

use yii\db\Migration;

class m160309_134823_add_column_to_consultansts_lang_info extends Migration
{
    public function up()
    {
        $this->addColumn('fv_manual_consultants_lang', 'info', 'varchar(255) NOT NULL DEFAULT \'\'');
    }

    public function down()
    {
        $this->dropColumn('fv_manual_consultants_lang', 'info');
    }
}
