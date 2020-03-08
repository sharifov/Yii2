<?php

use thread\modules\sanatorium\Sanatorium;
use yii\db\Migration;

class m160304_144644_create_table_fv_sanatorium_discount_lang extends Migration
{
    /**
     *
     * @var type
     */
    public $tableSanatorium = 'fv_sanatorium_discount';

    /**
     *
     * @var type
     */
    public $tableSanatoriumLang = 'fv_sanatorium_discount_lang';



    public function init()
    {

        $this->db = Sanatorium::getDb();
        parent::init();
    }

    /**
     *
     */
    public function up()
    {
        $this->execute("
            CREATE TABLE `" . $this->tableSanatoriumLang . "` (
                `rid` int(11) unsigned NOT NULL COMMENT 'rid',
                `lang` varchar(5) NOT NULL COMMENT 'lang',
                `title` varchar(255) NOT NULL COMMENT 'title'
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Скидки в санатории lang';
        ");

        parent::up();
    }

    /**
     *
     */
    public function safeUp()
    {

        $this->execute("
            ALTER TABLE `" . $this->tableSanatoriumLang . "`
                ADD UNIQUE KEY `rid` (`rid`,`lang`);
        ");

        $this->execute("
            ALTER TABLE `" . $this->tableSanatoriumLang . "`
                ADD CONSTRAINT `" . $this->tableSanatoriumLang . "_ibfk_1` FOREIGN KEY (`rid`) REFERENCES `" . $this->tableSanatorium . "` (`id`) ON DELETE CASCADE;
        ");

        parent::safeUp();
    }

    /**
     *
     */
    public function safeDown()
    {
        $this->delete($this->tableSanatoriumLang);
        $this->dropTable($this->tableSanatoriumLang);

        parent::safeDown();
    }
}
