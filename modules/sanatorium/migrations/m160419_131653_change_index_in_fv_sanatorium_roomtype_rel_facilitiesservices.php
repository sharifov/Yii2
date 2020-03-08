<?php

use yii\db\Migration;

class m160419_131653_change_index_in_fv_sanatorium_roomtype_rel_facilitiesservices extends Migration
{

    public  $tableName = '{{%sanatorium_roomtype_rel_facilitiesservices}}';
    public $firstIndexName = 'fv_manual_facilities_rooms_ibfk_1';
    public $secondIndexName = 'fv_sanatorium_room_type_ibfk_1';

    public function up()
    {
        $this->dropForeignKey($this->firstIndexName, $this->tableName);
        $this->dropForeignKey($this->secondIndexName, $this->tableName);


        $this->addForeignKey(
            $this->firstIndexName,
            $this->tableName,
            'facilities_rooms_id',
            'fv_manual_facilities_rooms',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            $this->secondIndexName,
            $this->tableName,
            'room_type_id',
            'fv_sanatorium_room_type',
            'id',
            'CASCADE'
        );

    }

    public function down()
    {
        $this->dropForeignKey($this->firstIndexName, $this->tableName);
        $this->dropForeignKey($this->secondIndexName, $this->tableName);

        $this->addForeignKey(
            $this->firstIndexName,
            $this->tableName,
            'facilities_rooms_id',
            'fv_manual_facilities_rooms',
            'id'
        );

        $this->addForeignKey(
            $this->secondIndexName,
            $this->tableName,
            'room_type_id',
            'fv_sanatorium_room_type',
            'id'
        );

    }
}
