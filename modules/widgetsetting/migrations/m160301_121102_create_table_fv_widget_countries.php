<?php

use thread\modules\widgetsetting\Widgetsetting;
use yii\db\Migration;

class m160301_121102_create_table_fv_widget_countries extends Migration
{
    public $tableSanatoriumRooms = 'fv_widget_countries';

    public function init() {

        $this->db = Widgetsetting::getDb();
        parent::init();
    }

    public function up() {
        $this->execute("
        CREATE TABLE `" . $this->tableSanatoriumRooms . "` (
              `id` int(11) unsigned NOT NULL COMMENT 'id',
              `country_id` int(11) unsigned NOT NULL  COMMENT 'страна',
              `cities_id` varchar(255) NOT NULL DEFAULT '' COMMENT 'список стран serialize()',
              `image_link` varchar(255) NOT NULL DEFAULT '' COMMENT 'фото города',
              `main_city_id` int(11) unsigned NOT NULL COMMENT 'основной город',
              `position` int(11) unsigned NOT NULL DEFAULT 0 COMMENT 'sort (position)',
              `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT 'create_time',
              `update_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT 'update_time',
              `published` enum('0','1') NOT NULL DEFAULT '0' COMMENT 'published',
              `deleted` enum('0','1') NOT NULL DEFAULT '0' COMMENT 'deleted'
            ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='Виджет страны';
        ");

        parent::up();
    }

    public function safeUp() {

        $this->execute("
            ALTER TABLE `" . $this->tableSanatoriumRooms . "`
               ADD PRIMARY KEY (`id`),
               ADD KEY `deleted` (`deleted`),
               ADD KEY `published` (`published`)
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
