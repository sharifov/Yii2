<?php


use yii\db\Migration;
use thread\modules\location\Location;

class m160209_091905_create_table_location_city_lang extends Migration
{
    public $tableLocationCity = 'fv_location_city';

    /**
     *
     * @var type
     */
    public $tableLocationCityLang = 'fv_location_city_lang';


    public function init() {

        $this->db = Location::getDb();
        parent::init();
    }

    public function up() {
        $this->execute("
         CREATE TABLE `". $this->tableLocationCityLang ."` (
              `rid` int(11) unsigned NOT NULL COMMENT 'rid',
              `lang` varchar(5) NOT NULL COMMENT 'lang',
              `title` varchar(255) NOT NULL COMMENT 'title'
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='location city lang';
        ");

        parent::up();
    }

    public function safeUp() {

        $this->execute("
            ALTER TABLE `". $this->tableLocationCityLang  ."`
                ADD UNIQUE KEY `rid` (`rid`,`lang`);
        ");

        $this->execute("
            ALTER TABLE `". $this->tableLocationCityLang  ."`
                ADD CONSTRAINT `".$this->tableLocationCityLang  ."_ibfk_1` FOREIGN KEY (`rid`) REFERENCES `". $this->tableLocationCity  ."` (`id`)  ON DELETE CASCADE;
        ");


        parent::safeUp();
    }

    public function safeDown() {
        $this->delete($this->tableLocationCityLang );
        $this->dropTable($this->tableLocationCityLang );

        parent::safeDown();
    }
}
