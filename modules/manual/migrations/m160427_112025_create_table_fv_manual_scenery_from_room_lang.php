<?php

use thread\modules\manual\Manual;
use yii\db\Migration;

/**
 * Handles the creation for table `table_fv_manual_scenery_from_room_lang`.
 */
class m160427_112025_create_table_fv_manual_scenery_from_room_lang extends Migration
{
    /**
     *
     * @var type
     */
    public $main = 'fv_manual_scenery_from_room';

    /**
     *
     * @var type
     */
    public $lang = 'fv_manual_scenery_from_room_lang';

    /**
     *
     */
    public function init() {

        $this->db = Manual::getDb();
        parent::init();
    }

    public function up() {
        $this->execute("
        CREATE TABLE `". $this->lang  ."` (
            `rid` int(11) unsigned NOT NULL COMMENT 'rid',
            `lang` varchar(5) DEFAULT NULL COMMENT 'lang',
            `title` varchar(255) DEFAULT NULL COMMENT 'title'
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Вид из номера lang';
        ");

        parent::up();
    }

    public function safeUp() {

        $this->execute("
            ALTER TABLE `". $this->lang ."`
                ADD UNIQUE KEY `rid` (`rid`,`lang`);
        ");

        $this->execute("
            ALTER TABLE `". $this->lang  ."`
                ADD CONSTRAINT `".$this->lang ."_ibfk_1` FOREIGN KEY (`rid`) REFERENCES `". $this->main  ."` (`id`);
        ");


        parent::safeUp();
    }


    public function safeDown() {
        $this->delete($this->lang );
        $this->dropTable($this->lang );

        parent::safeDown();
    }
}
