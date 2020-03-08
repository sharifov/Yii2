<?php

use yii\db\Migration;

class m160305_090604_add_table_to_fv_sanatorium_discount_sanatorium_id extends Migration
{
    public function up()
    {
        $this->addColumn('fv_sanatorium_discount', 'sanatorium_id', 'int(11) unsigned DEFAULT NULL COMMENT \'санаторий_id\'');
        $this->addForeignKey('sanatorium_id_ibfk_1', 'fv_sanatorium_discount', 'sanatorium_id', 'fv_sanatorium_sanatoriums', 'id', 'CASCADE');
    }

    public function down()
    {
        $this->dropForeignKey('sanatorium_id_ibfk_1', 'fv_sanatorium_discount');
        $this->dropColumn('fv_sanatorium_discount', 'sanatorium_id');
    }
}
