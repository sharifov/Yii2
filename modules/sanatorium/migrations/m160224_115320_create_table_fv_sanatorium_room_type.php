<?php

use thread\modules\sanatorium\Sanatorium;
use yii\db\Migration;

class m160224_115320_create_table_fv_sanatorium_room_type extends Migration
{
    /**
     *
     * @var type
     */
    public $tableSanatorium = 'fv_sanatorium_room_type';

    /**
     *
     * @var type
     */
    public $tableSanatoriumLang = 'fv_sanatorium_room_type_lang';

    /**
     *
     */
    public function init()
    {

        $this->db = Sanatorium::getDb();
        parent::init();
    }

    /**
     *
     */
    public function up()
    {
        $this->execute("
          CREATE TABLE `" . $this->tableSanatorium . "` (
              `id` int(11) unsigned NOT NULL  COMMENT 'id',
              `alias` varchar(255) DEFAULT '' COMMENT 'alias',
               `manual_rooms_id` int(11) unsigned NOT NULL  COMMENT 'Тип номера',
               `sanatorium_id`  int(11) unsigned NOT NULL  COMMENT 'Санаторий id',
               `number_rooms` int(11) unsigned NOT NULL DEFAULT '0' COMMENT 'Количество номеров этого типа',
               `number_rooms_booking` int(11) unsigned NOT NULL DEFAULT '0' COMMENT 'Количество для продажи (бронирования)',
               `width_bed` varchar(128) NOT NULL DEFAULT '' COMMENT 'ширина кровати',
               `extra_bad` int(1) NOT NULL DEFAULT '0' COMMENT 'Дополнительная кровать?',
               `room_size` int(11) NOT NULL DEFAULT '0' COMMENT 'Размер номера',
              `number_extra_bad` int(11) unsigned NOT NULL DEFAULT '0' COMMENT 'Возможное количество доп кроватей',
              `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT 'create_time',
              `update_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT 'update_time',
              `published` enum('0','1') NOT NULL DEFAULT '0' COMMENT 'published',
              `deleted` enum('0','1') NOT NULL DEFAULT '0' COMMENT 'deleted'
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Типы номеров в санатории';
        ");

        parent::up();
    }

    /**
     *
     */
    public function safeUp()
    {

        $this->execute("
            ALTER TABLE `" . $this->tableSanatorium . "`
                   ADD PRIMARY KEY (`id`),
                   ADD UNIQUE KEY `alias` (`alias`),
                   ADD KEY `deleted` (`deleted`),
                   ADD KEY `published` (`published`),
                   ADD KEY `fv_sanatorium_sanatoriums_ibfk_1` (`sanatorium_id`),
                   ADD KEY `fv_manual_rooms_ibfk_1` (`manual_rooms_id`)
        ");

        $this->execute("
            ALTER TABLE `" . $this->tableSanatorium . "`
                MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'id', AUTO_INCREMENT=1;
        ");

        $this->execute("
            ALTER TABLE `" . $this->tableSanatorium . "`
                ADD CONSTRAINT `fv_sanatorium_sanatoriums_ibfk_1` FOREIGN KEY (`sanatorium_id`) REFERENCES `fv_sanatorium_sanatoriums` (`id`),
                ADD CONSTRAINT `fv_manual_rooms_ibfk_1` FOREIGN KEY (`manual_rooms_id`) REFERENCES `fv_manual_rooms` (`id`)
        ");

        parent::safeUp();
    }

    /**
     *
     */
    public function safeDown()
    {
        $this->delete($this->tableNewsGroup);
        $this->dropTable($this->tableSanatorium);
        parent::safeDown();
    }
}
