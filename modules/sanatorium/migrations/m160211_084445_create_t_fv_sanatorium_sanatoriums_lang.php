<?php

use yii\db\Migration;
use thread\modules\sanatorium\Sanatorium;

class m160211_084445_create_t_fv_sanatorium_sanatoriums_lang extends Migration
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
            CREATE TABLE `".$this->tableSanatoriumLang."` (
                `rid` int(11) UNSIGNED NOT NULL COMMENT 'rid',
                `lang` varchar(5) NOT NULL COMMENT 'lang',
                `title` varchar(255) NOT NULL COMMENT 'title',
                `content` text COMMENT 'content'
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='lang';
        ");

        parent::up();
    }

    /**
     *
     */
    public function safeUp() {

        $this->execute("
            ALTER TABLE `".$this->tableSanatoriumLang."`
                ADD UNIQUE KEY `rid` (`rid`,`lang`);
        ");

        $this->execute("
            ALTER TABLE `".$this->tableSanatoriumLang."`
                ADD CONSTRAINT `".$this->tableSanatoriumLang."_ibfk_1` FOREIGN KEY (`rid`) REFERENCES `".$this->tableSanatorium."` (`id`);
        ");

        parent::safeUp();
    }

    /**
     *
     */
    public function safeDown() {
        $this->delete($this->tableSanatoriumLang);
        $this->dropTable($this->tableSanatoriumLang);

        parent::safeDown();
    }
}
