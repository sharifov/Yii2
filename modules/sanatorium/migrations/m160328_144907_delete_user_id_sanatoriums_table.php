<?php

use yii\db\Migration;

class m160328_144907_delete_user_id_sanatoriums_table extends Migration
{
    public function up()
    {
        $this->dropColumn('fv_sanatorium_sanatoriums', 'user_id');
    }

    public function down()
    {
        $this->addColumn('fv_sanatorium_sanatoriums', 'user_id', 'int(11) unsigned NOT NULL COMMENT \'user_id\' AFTER deleted');
    }
}
