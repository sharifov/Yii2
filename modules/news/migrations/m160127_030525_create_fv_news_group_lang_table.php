<?php

use yii\db\Migration;
use thread\modules\news\News;

/**
 * Class m160127_030515_create_fv_news_group_table
 *
 * @package thread\modules\news
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c) 2015, Thread
 */
class m160127_030525_create_fv_news_group_lang_table extends Migration {

    /**
     *
     * @var type
     */
    public $tableNewsGroup = 'fv_news_group';

    /**
     *
     * @var type
     */
    public $tableNewsGroupLang = 'fv_news_group_lang';

    /**
     *
     */
    public function init() {

        $this->db = News::getDb();
        parent::init();
    }

    /**
     *
     */
    public function up() {
        $this->execute("
            CREATE TABLE `".$this->tableNewsGroupLang."` (
                `rid` int(11) UNSIGNED NOT NULL COMMENT 'rid',
                `lang` varchar(5) NOT NULL COMMENT 'lang',
                `title` varchar(255) NOT NULL COMMENT 'title'
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='news group lang';
        ");

        parent::up();
    }

    /**
     *
     */
    public function safeUp() {

        $this->execute("
            ALTER TABLE `".$this->tableNewsGroupLang."`
                ADD UNIQUE KEY `rid` (`rid`,`lang`);
        ");

        $this->execute("
            ALTER TABLE `".$this->tableNewsGroupLang."`
                ADD CONSTRAINT `".$this->tableNewsGroupLang."_ibfk_1` FOREIGN KEY (`rid`) REFERENCES `".$this->tableNewsGroup."` (`id`);
        ");

        parent::safeUp();
    }

    /**
     *
     */
    public function safeDown() {
        $this->delete($this->tableNewsGroupLang);
        $this->dropTable($this->tableNewsGroupLang);

        parent::safeDown();
    }

}
