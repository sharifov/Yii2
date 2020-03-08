<?php

use yii\db\Migration;

class m160224_095525_fix_fv_manual_services_lang extends Migration
{
    public function up()
    {
        $this->alterColumn('fv_manual_services_lang', 'lang', 'varchar(5) NOT NULL');
    }

    public function down()
    {
        $this->alterColumn('fv_manual_services_lang', 'lang', 'varchar(5) NOT NULL');
    }


}
