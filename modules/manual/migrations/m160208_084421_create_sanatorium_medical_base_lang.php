<?php

use yii\db\Migration;
use thread\modules\manual\Manual;

class m160208_084421_create_sanatorium_medical_base_lang extends Migration
{
    public $tableSanatoriumMedicalBase = 'fv_manual_medical_base';

    /**
     *
     * @var type
     */
    public $tableSanatoriumMedicalBaseLang = 'fv_manual_medical_base_lang';

    public function init() {

        $this->db = Manual::getDb();
        parent::init();
    }

    public function up() {
        $this->execute("
          CREATE TABLE `". $this->tableSanatoriumMedicalBaseLang ."` (
              `rid` int(11) unsigned NOT NULL COMMENT 'rid',
              `lang` varchar(5) DEFAULT NULL COMMENT 'lang',
              `title` varchar(255) DEFAULT NULL COMMENT 'title'
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='medical base rooms lang';
        ");

        parent::up();
    }

    public function safeUp() {

        $this->execute("
            ALTER TABLE `". $this->tableSanatoriumMedicalBaseLang ."`
                ADD UNIQUE KEY `rid` (`rid`,`lang`);
        ");

        $this->execute("
            ALTER TABLE `". $this->tableSanatoriumMedicalBaseLang ."`
                ADD CONSTRAINT `".$this->tableSanatoriumMedicalBaseLang ."_ibfk_1` FOREIGN KEY (`rid`) REFERENCES `". $this->tableSanatoriumMedicalBase  ."` (`id`);
        ");


        parent::safeUp();
    }

    public function safeDown() {
        $this->delete($this->tableSanatoriumMedicalBaseLang);
        $this->dropTable($this->tableSanatoriumMedicalBaseLang);

        parent::safeDown();
    }
}
