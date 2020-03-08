<?php

use yii\db\Migration;

class m160224_094223_fix_rooms_lang extends Migration
{
    public function up()
    {
        $this->alterColumn('fv_manual_rooms_lang', 'lang', 'varchar(5) NOT NULL');
    }

    public function down()
    {
        $this->alterColumn('fv_manual_rooms_lang', 'lang', 'varchar(5) NOT NULL');
    }

}
