<?php

use yii\db\Migration;
use thread\modules\manual\Manual;

class m160208_084507_create_sanatorium_rooms_lang extends Migration
{
    public $tableSanatoriumRooms = 'fv_manual_rooms';
    /**
     *
     * @var type
     */
    public $tableSanatoriumRoomsLang = 'fv_manual_rooms_lang';

    public function init() {

        $this->db = Manual::getDb();
        parent::init();
    }

    public function up() {
        $this->execute("
        CREATE TABLE `". $this->tableSanatoriumRoomsLang  ."` (
            `rid` int(11) unsigned NOT NULL COMMENT 'rid',
            `lang` varchar(5) DEFAULT NULL COMMENT 'lang',
            `title` varchar(255) DEFAULT NULL COMMENT 'title'
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='medical base rooms lang';
        ");

        parent::up();
    }

    public function safeUp() {

        $this->execute("
            ALTER TABLE `". $this->tableSanatoriumRoomsLang ."`
                ADD UNIQUE KEY `rid` (`rid`,`lang`);
        ");

        $this->execute("
            ALTER TABLE `". $this->tableSanatoriumRoomsLang  ."`
                ADD CONSTRAINT `".$this->tableSanatoriumRoomsLang ."_ibfk_1` FOREIGN KEY (`rid`) REFERENCES `". $this->tableSanatoriumRooms  ."` (`id`);
        ");


        parent::safeUp();
    }


    public function safeDown() {
        $this->delete($this->tableSanatoriumRoomsLang );
        $this->dropTable($this->tableSanatoriumRoomsLang );

        parent::safeDown();
    }
}
