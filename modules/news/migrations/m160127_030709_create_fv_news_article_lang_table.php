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
class m160127_030709_create_fv_news_article_lang_table extends Migration {

    /**
     *
     * @var type
     */
    public $tableNewsArticle = 'fv_news_article';

    /**
     *
     * @var type
     */
    public $tableNewsArticleLang = 'fv_news_article_lang';

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
            CREATE TABLE `".$this->tableNewsArticleLang."` (
                `rid` int(11) UNSIGNED NOT NULL COMMENT 'rid',
                `lang` varchar(5) NOT NULL COMMENT 'lang',
                `title` varchar(255) NOT NULL COMMENT 'title',
                `description` varchar(255) NOT NULL DEFAULT '' COMMENT 'description',
                `content` text NOT NULL COMMENT 'content'
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='news article lang';
        ");

        parent::up();
    }

    /**
     *
     */
    public function safeUp() {

        $this->execute("
            ALTER TABLE `".$this->tableNewsArticleLang."`
                ADD UNIQUE KEY `rid` (`rid`,`lang`);
        ");

        $this->execute("
            ALTER TABLE `".$this->tableNewsArticleLang."`
                ADD CONSTRAINT `".$this->tableNewsArticleLang."_ibfk_1` FOREIGN KEY (`rid`) REFERENCES `".$this->tableNewsArticle."` (`id`);
        ");

        parent::safeUp();
    }

    /**
     *
     */
    public function safeDown() {
        $this->delete($this->tableNewsArticleLang);
        $this->dropTable($this->tableNewsArticleLang);

        parent::safeDown();
    }

}
