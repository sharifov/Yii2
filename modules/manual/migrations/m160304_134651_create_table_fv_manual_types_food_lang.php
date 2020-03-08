<?php

use thread\modules\manual\Manual;
use yii\db\Migration;

class m160304_134651_create_table_fv_manual_types_food_lang extends Migration
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
        CREATE TABLE `". $this->tableSanatoriumRoomsLang  ."` (
            `rid` int(11) unsigned NOT NULL COMMENT 'rid',
            `lang` varchar(5) NOT NULL COMMENT 'lang',
            `title` varchar(255) NOT NULL COMMENT 'title'
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Типы питания lang';
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
