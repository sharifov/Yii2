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
class m160127_030655_create_fv_news_article_table extends Migration {

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
            CREATE TABLE `".$this->tableNewsArticle."` (
                `id` int(11) UNSIGNED NOT NULL COMMENT 'id',
                `group_id` int(11) UNSIGNED NOT NULL COMMENT 'group',
                `alias` varchar(255) NOT NULL COMMENT 'alias',
                `image_link` varchar(255) DEFAULT NULL COMMENT 'image_link',
                `published_time` int(11) UNSIGNED NOT NULL DEFAULT '0' COMMENT 'published_time',
                `create_time` int(11) UNSIGNED NOT NULL DEFAULT '0' COMMENT 'create_time',
                `update_time` int(11) UNSIGNED NOT NULL DEFAULT '0' COMMENT 'update_time',
                `published` enum('0','1') NOT NULL DEFAULT '0' COMMENT 'published',
                `deleted` enum('0','1') NOT NULL DEFAULT '0' COMMENT 'deleted'
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='news article';
        ");

        parent::up();
    }

    /**
     *
     */
    public function safeUp() {

        $this->execute("
            ALTER TABLE `".$this->tableNewsArticle."`
                ADD PRIMARY KEY (`id`),
                ADD UNIQUE KEY `alias` (`alias`),
                ADD KEY `deleted` (`deleted`),
                ADD KEY `published` (`published`),
                ADD KEY `group` (`group_id`),
                ADD KEY `published_time` (`published_time`);
        ");

        $this->execute("
            ALTER TABLE `".$this->tableNewsArticle."`
                MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'id', AUTO_INCREMENT=3;
        ");

        parent::safeUp();
    }

    /**
     *
     */
    public function safeDown() {
        $this->delete($this->tableNewsArticle);
        $this->dropTable($this->tableNewsArticle);

        parent::safeDown();
    }

}
