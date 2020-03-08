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
class m160127_030515_create_fv_news_group_table extends Migration {

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
            CREATE TABLE `" . $this->tableNewsGroup . "` (
                `id` int(11) UNSIGNED NOT NULL COMMENT 'id',
                `alias` varchar(255) NOT NULL COMMENT 'alias',
                `create_time` int(11) UNSIGNED NOT NULL DEFAULT '0' COMMENT 'create_time',
                `update_time` int(11) UNSIGNED NOT NULL DEFAULT '0' COMMENT 'update_time',
                `published` enum('0','1') NOT NULL DEFAULT '0' COMMENT 'published',
                `deleted` enum('0','1') NOT NULL DEFAULT '0' COMMENT 'deleted'
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='news group';
        ");

        parent::up();
    }

    /**
     *
     */
    public function safeUp() {

        $this->execute("
            ALTER TABLE `" . $this->tableNewsGroup . "`
                ADD PRIMARY KEY (`id`),
                ADD UNIQUE KEY `alias` (`alias`),
                ADD KEY `deleted` (`deleted`),
                ADD KEY `published` (`published`);
        ");

        $this->execute("
            ALTER TABLE `" . $this->tableNewsGroup . "`
                MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'id', AUTO_INCREMENT=1;
        ");

        parent::safeUp();
    }

    /**
     *
     */
    public function safeDown() {
        $this->delete($this->tableNewsGroup);
        $this->dropTable($this->tableNewsGroup);

        parent::safeDown();
    }

}
