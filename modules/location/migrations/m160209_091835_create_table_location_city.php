<?php


use yii\db\Migration;
use thread\modules\location\Location;

class m160209_091835_create_table_location_city extends Migration
{

    /**
     *
     * @var type
     */
    public $tableLocationCity = 'fv_location_city';

    /**
     *
     * @var type
     */
    public $tableLocationCityLang = 'fv_location_city_lang';

    /**
     *
     */
    public function init() {

        $this->db = Location::getDb();
        parent::init();
    }

    /**
     *
     */
    public function up() {
        $this->execute("
            CREATE TABLE `".$this->tableLocationCity."` (
                  `id` int(11) UNSIGNED NOT NULL COMMENT 'id',
                  `location_country_id` int(11) UNSIGNED DEFAULT NULL COMMENT 'страна id',
                  `alias` varchar(255) DEFAULT '' COMMENT 'alias',
                  `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT 'create_time',
                  `update_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT 'update_time',
                  `published` enum('0','1') NOT NULL DEFAULT '0' COMMENT 'published',
                  `deleted` enum('0','1') NOT NULL DEFAULT '0' COMMENT 'deleted'
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Вид номера';
        ");

        parent::up();
    }

    /**
     *
     */
    public function safeUp() {

        $this->execute("
            ALTER TABLE `".$this->tableLocationCity."`
                ADD PRIMARY KEY (`id`),
                 ADD UNIQUE KEY `alias` (`alias`),
                 ADD KEY `deleted` (`deleted`),
                 ADD KEY `published` (`published`),
                 ADD KEY `location_country_id` (`location_country_id`);

        ");

        $this->execute("
            ALTER TABLE `".$this->tableLocationCity."`
                 MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'id', AUTO_INCREMENT=1;
        ");

        $this->execute("
            ALTER TABLE `" . $this->tableLocationCity . "`
                ADD CONSTRAINT `" . $this->tableLocationCity . "_ibfk_1` FOREIGN KEY (`location_country_id`) REFERENCES `fv_location_country` (`id`) ON DELETE CASCADE;
        ");

        parent::safeUp();
    }

    /**
     *
     */
    public function safeDown() {
        $this->delete($this->tableLocationCity);
        $this->dropTable($this->tableLocationCity);

        parent::safeDown();
    }

}
