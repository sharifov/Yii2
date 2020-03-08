<?php

use yii\db\Migration;
use thread\modules\page\Page;

/**
 * Class m160126_224818_create_fv_page_table
 *
 * @package thread\modules\page
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c) 2015, Thread
 */

class m160126_224818_create_fv_page_table extends Migration {

    /**
     *
     * @var type
     */
    public $tablePage = 'fv_page';

    /**
     *
     * @var type
     */
    public $tablePageLang = 'fv_page_lang';

    /**
     *
     */
    public function init() {

        $this->db = Page::getDb();
        parent::init();
    }

    /**
     *
     */
    public function up() {
        $this->execute("
            CREATE TABLE `" . $this->tablePage . "` (
                `id` int(11) UNSIGNED NOT NULL COMMENT 'id',
                `alias` varchar(255) NOT NULL COMMENT 'alias',
                `image_link` varchar(255) DEFAULT NULL COMMENT 'image_link',
                `create_time` int(11) UNSIGNED NOT NULL DEFAULT '0' COMMENT 'create_time',
                `update_time` int(11) UNSIGNED NOT NULL DEFAULT '0' COMMENT 'update_time',
                `published` enum('0','1') NOT NULL DEFAULT '0' COMMENT 'published',
                `deleted` enum('0','1') NOT NULL DEFAULT '0' COMMENT 'deleted'
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='page';
        ");

        parent::up();
    }

    /**
     *
     */
    public function safeUp() {
        $this->execute("
            ALTER TABLE `" . $this->tablePage . "`
                ADD PRIMARY KEY (`id`),
                ADD UNIQUE KEY `alias` (`alias`),
                ADD KEY `deleted` (`deleted`),
                ADD KEY `published` (`published`);
        ");

        $this->execute("
            ALTER TABLE `" . $this->tablePage . "`
                MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'id', AUTO_INCREMENT=1;
        ");

        parent::safeUp();
    }

    /**
     *
     */
    public function safeDown() {
        $this->delete($this->tablePage);
        $this->dropTable($this->tablePage);

        parent::safeDown();
    }

}
