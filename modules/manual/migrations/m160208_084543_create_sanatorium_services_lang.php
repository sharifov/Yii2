<?php

use yii\db\Migration;
use thread\modules\manual\Manual;

class m160208_084543_create_sanatorium_services_lang extends Migration
{
    public $tableSanatoriumServices = 'fv_manual_services';

    /**
     *
     * @var type
     */
    public $tableSanatoriumServicesLang = 'fv_manual_services_lang';

    public function init() {

        $this->db = Manual::getDb();
        parent::init();
    }

    public function up() {
        $this->execute("
         CREATE TABLE `". $this->tableSanatoriumServicesLang ."` (
              `rid` int(11) unsigned NOT NULL COMMENT 'rid',
              `lang` varchar(5) DEFAULT NULL COMMENT 'lang',
              `title` varchar(255) DEFAULT NULL COMMENT 'title',
              `desc_short` varchar(255) DEFAULT NULL COMMENT 'short description'
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='sanatorium services lang';
        ");

        parent::up();
    }

    public function safeUp() {

        $this->execute("
            ALTER TABLE `". $this->tableSanatoriumServicesLang  ."`
                ADD UNIQUE KEY `rid` (`rid`,`lang`);
        ");

        $this->execute("
            ALTER TABLE `". $this->tableSanatoriumServicesLang  ."`
                ADD CONSTRAINT `".$this->tableSanatoriumServicesLang  ."_ibfk_1` FOREIGN KEY (`rid`) REFERENCES `". $this->tableSanatoriumServices  ."` (`id`);
        ");


        parent::safeUp();
    }

    public function safeDown() {
        $this->delete($this->tableSanatoriumServicesLang );
        $this->dropTable($this->tableSanatoriumServicesLang );

        parent::safeDown();
    }
}
