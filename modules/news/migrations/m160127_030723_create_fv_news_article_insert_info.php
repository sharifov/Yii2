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
class m160127_030723_create_fv_news_article_insert_info extends Migration {

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
    public function safeUp() {

        $this->execute("
            INSERT INTO `" . $this->tableNewsArticle . "` (`id`, `group_id`, `alias`, `image_link`, `published_time`, `create_time`, `update_time`, `published`, `deleted`) VALUES
                (1, 1, 'article', '54d3e5d961a94.jpeg', 1330034400, 1409267458, 1429910673, '1', '0');
        ");

        $this->execute("
            INSERT INTO `" . $this->tableNewsArticleLang . "` (`rid`, `lang`, `title`, `description`, `content`) VALUES
                (1, 'en-EN', 'article', '<p>description</p>', '<p>page</p>'),
                (1, 'ru-RU', 'статья', '<p>описание</p>', '<p>страница</p>');
        ");

        parent::safeUp();
    }

    /**
     *
     */
    public function safeDown() {
        $this->delete($this->tableNewsArticle);

        parent::safeDown();
    }

}
