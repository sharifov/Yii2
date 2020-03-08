<?php

use yii\db\Migration;

class m160224_082853_add_clumn_to_rooms_lang_info extends Migration
{
    public function up()
    {
        $this->addColumn('fv_manual_rooms_lang', 'info', 'varchar(255) DEFAULT NULL');
    }

    public function down()
    {
        $this->dropColumn('fv_manual_rooms_lang', 'info');
    }
}
