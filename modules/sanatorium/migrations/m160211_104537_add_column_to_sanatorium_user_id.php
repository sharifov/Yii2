<?php

use yii\db\Migration;

class m160211_104537_add_column_to_sanatorium_user_id extends Migration
{
    public function up()
    {
        $this->addColumn('fv_sanatorium_sanatoriums','user_id' , 'int(11) DEFAULT NULL');
    }

    public function down()
    {
        $this->dropColumn('fv_sanatorium_sanatoriums', 'user_id');
    }
}
