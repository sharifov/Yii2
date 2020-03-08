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
class m160127_030542_create_fv_news_group_insert_info extends Migration {

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
    public function safeUp() {

        $this->execute("
            INSERT INTO `" . $this->tableNewsGroup . "` (`id`, `alias`, `create_time`, `update_time`, `published`, `deleted`) VALUES
                (1, 'group', 1409266446, 1429913031, '1', '0');
        ");

        $this->execute("
            INSERT INTO `" . $this->tableNewsGroupLang . "` (`rid`, `lang`, `title`) VALUES
                (1, 'en-EN', 'group'),
                (1, 'ru-RU', 'группа'),
                (1, 'uk-UA', 'група');
        ");

        parent::safeUp();
    }

    /**
     *
     */
    public function safeDown() {
        $this->delete($this->tableNewsGroup);

        parent::safeDown();
    }

}
