<?php

use thread\modules\manual\Manual;
use yii\db\Migration;

class m160304_134637_create_table_fv_manual_types_food extends Migration
{
    public $tableSanatoriumRooms = 'fv_manual_types_food';
    /**
     *
     * @var type
     */
    public $tableSanatoriumRoomsLang = 'fv_manual_types_food_lang';

    public function init() {

        $this->db = Manual::getDb();
        parent::init();
    }

    public function up() {
        $this->execute("
         CREATE TABLE `". $this->tableSanatoriumRooms ."` (
              `id` int(11) unsigned NOT NULL COMMENT 'id',
              `position` int(11) NOT NULL DEFAULT '0' COMMENT 'position',
              `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT 'create_time',
              `update_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT 'update_time',
              `published` enum('0','1') NOT NULL DEFAULT '0' COMMENT 'published',
              `deleted` enum('0','1') NOT NULL DEFAULT '0' COMMENT 'deleted'
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Типы питания';
        ");

        parent::up();
    }

    public function safeUp() {

        $this->execute("
            ALTER TABLE `" . $this->tableSanatoriumRooms . "`
                ADD PRIMARY KEY (`id`),
                ADD KEY `deleted` (`deleted`),
                ADD KEY `published` (`published`);
        ");

        $this->execute("
            ALTER TABLE `". $this->tableSanatoriumRooms ."`
                MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'id', AUTO_INCREMENT=1;
        ");


        parent::safeUp();
    }

    public function safeDown() {
        $this->delete($this->tableSanatoriumRooms);
        $this->dropTable($this->tableSanatoriumRooms);

        parent::safeDown();
    }
}
