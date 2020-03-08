<?php

use thread\modules\sanatorium\Sanatorium;
use yii\db\Migration;

class m160211_084432_create_t_fv_sanatorium_sanatoriums extends Migration
{
    /**
     *
     * @var type
     */
    public $tableSanatorium = 'fv_sanatorium_sanatoriums';

    /**
     *
     * @var type
     */
    public $tableSanatoriumLang = 'fv_sanatorium_sanatoriums_lang';

    /**
     *
     */
    public function init() {

        $this->db = Sanatorium::getDb();
        parent::init();
    }

    /**
     *
     */
    public function up() {
        $this->execute("
           CREATE TABLE `". $this->tableSanatorium ."` (
                  `id` int(11) unsigned NOT NULL COMMENT 'id',
                  `alias` varchar(255) DEFAULT '' COMMENT 'alias',
                  `address` varchar(256) DEFAULT '' COMMENT 'адресс',
                  `address_www` varchar(256) DEFAULT '' COMMENT 'сайт',
                  `address_www_booking` varchar(256) DEFAULT '' COMMENT 'сайт для бронирования',
                  `location_country_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT 'id страны',
                  `location_city_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT 'id города  !! ДОБАВИТЬ ИНДЕКС !!!!!',
                  `phone` varchar(128) DEFAULT '' COMMENT 'телефон',
                  `fax` varchar(128) DEFAULT '' COMMENT 'факс',
                  `postcode` varchar(128) DEFAULT '' COMMENT 'почтовый индекс',
                  `rating` enum('1','2','3','4','5') NOT NULL DEFAULT '1' COMMENT 'рейтинг количество звезд',
                  `latitude_map` varchar(128) DEFAULT '' COMMENT 'широта на карте',
                  `longitude_map` varchar(128) DEFAULT '' COMMENT 'долгота на карте',
                  `address_map` varchar(256) DEFAULT '' COMMENT 'адресс на карте',

                  `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT 'create_time',
                  `update_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT 'update_time',
                  `published` enum('0','1') NOT NULL DEFAULT '0' COMMENT 'published',
                  `deleted` enum('0','1') NOT NULL DEFAULT '0' COMMENT 'deleted'
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Список санаториев';
        ");

        parent::up();
    }

    /**
     *
     */
    public function safeUp() {

        $this->execute("
            ALTER TABLE `" . $this->tableSanatorium . "`
                  ADD PRIMARY KEY (`id`),
                  ADD UNIQUE KEY `alias` (`alias`),
                  ADD KEY `deleted` (`deleted`),
                  ADD KEY `published` (`published`),
                  ADD KEY `fv_location_country_ibfk_1` (`location_country_id`),
                  ADD KEY `location_city_id_ibfk_1` (`location_city_id`)
        ");

        $this->execute("
            ALTER TABLE `" . $this->tableSanatorium . "`
                MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'id', AUTO_INCREMENT=1;
        ");

        $this->execute("
            ALTER TABLE `".$this->tableSanatorium."`
                ADD CONSTRAINT `fv_location_country_ibfk_1` FOREIGN KEY (`location_country_id`) REFERENCES `fv_location_country` (`id`),
                ADD CONSTRAINT `location_city_id_ibfk_1` FOREIGN KEY (`location_city_id`) REFERENCES `fv_location_city` (`id`)
        ");

        parent::safeUp();
    }

    /**
     *
     */
    public function safeDown() {
        $this->delete($this->tableNewsGroup);
        $this->dropTable($this->tableSanatorium);

        parent::safeDown();
    }

}
