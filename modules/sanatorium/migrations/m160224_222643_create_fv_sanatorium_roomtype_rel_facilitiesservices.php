<?php

use yii\db\Migration;

class m160224_222643_create_fv_sanatorium_roomtype_rel_facilitiesservices extends Migration
{
    public function up()
    {
        $this->execute("
          CREATE TABLE `fv_sanatorium_roomtype_rel_facilitiesservices` (
              `id` int(11) unsigned NOT NULL  COMMENT 'id',
              `room_type_id` int(11) unsigned NOT NULL  COMMENT 'room_type_id',
              `facilities_rooms_id` int(11) unsigned NOT NULL  COMMENT 'Удобство номера'
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Типы номеров в санатории';
        ");

        $this->execute("
            ALTER TABLE `fv_sanatorium_roomtype_rel_facilitiesservices`
                   ADD PRIMARY KEY (`id`),
                   ADD KEY `fv_sanatorium_room_type_ibfk_1` (`room_type_id`),
                   ADD KEY `fv_manual_facilities_rooms_ibfk_1` (`facilities_rooms_id`);
        ");

        $this->execute("
            ALTER TABLE `fv_sanatorium_roomtype_rel_facilitiesservices`
                MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'id', AUTO_INCREMENT=1;
        ");


        $this->execute("
            ALTER TABLE `fv_sanatorium_roomtype_rel_facilitiesservices`
                ADD CONSTRAINT `fv_manual_facilities_rooms_ibfk_1` FOREIGN KEY (`facilities_rooms_id`) REFERENCES `fv_manual_facilities_rooms` (`id`),
                ADD CONSTRAINT `fv_sanatorium_room_type_ibfk_1` FOREIGN KEY (`room_type_id`) REFERENCES `fv_sanatorium_room_type` (`id`)
        ");

    }

    public function down()
    {
        $this->dropTable('fv_sanatorium_roomtype_rel_facilitiesservices');
    }
}
