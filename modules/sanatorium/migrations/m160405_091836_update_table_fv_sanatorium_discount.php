<?php

use yii\db\Migration;

class m160405_091836_update_table_fv_sanatorium_discount extends Migration
{
    public $table = '{{%sanatorium_discount}}';

    public function up()
    {
        $this->dropColumn($this->table ,'manual_room_id');
        $this->addColumn($this->table ,'sanatorium_room_type', 'int(11) unsigned NOT NULL COMMENT\' Тип номера санатория\'');
        $this->addForeignKey('fv_sanatorium_discount_fv_sanatorium_room_ibfk_1', $this->table , 'sanatorium_room_type', 'fv_sanatorium_room_type', 'id', 'CASCADE');
    }

    public function down()
    {
        $this->addColumn($this->table ,'manual_room_id', 'int(11)');
        $this->dropColumn($this->table ,'sanatorium_room_type');
    }

}
