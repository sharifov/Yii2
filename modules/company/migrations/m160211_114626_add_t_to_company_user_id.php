<?php

use yii\db\Migration;

class m160211_114626_add_t_to_company_user_id extends Migration
{
    public function up()
    {
        $this->addColumn('fv_company','user_id' , 'int(11) DEFAULT NULL');
    }

    public function down()
    {
        $this->dropColumn('fv_sanatorium_sanatoriums', 'user_id');
    }
}
