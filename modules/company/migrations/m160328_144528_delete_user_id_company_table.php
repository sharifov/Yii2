<?php

use yii\db\Migration;

class m160328_144528_delete_user_id_company_table extends Migration
{
    public function up()
    {
        $this->dropColumn('fv_company', 'user_id');
    }

    public function down()
    {
        $this->addColumn('fv_company', 'user_id', 'int(11) DEFAULT NULL');
    }
}
