<?php

use yii\db\Migration;
use thread\modules\menu\Menu;

/**
 * Class m160127_031125_create_fv_menu_table
 *
 * @package thread\modules\menu
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c) 2015, Thread
 */
class m160127_031125_create_fv_menu_table extends Migration {

    /**
     *
     * @var type
     */
    public $tableMenu = 'fv_menu';

    /**
     *
     * @var type
     */
    public $tableMenuLang = 'fv_menu_lang';

    /**
     *
     */
    public function init() {

        $this->db = Menu::getDb();
        parent::init();
    }

    /**
     *
     */
    public function up() {
        $this->execute("
            CREATE TABLE `" . $this->tableMenu . "` (
                `id` int(11) UNSIGNED NOT NULL COMMENT 'id',
                `alias` varchar(255) NOT NULL COMMENT 'alias',
                `create_time` int(11) UNSIGNED NOT NULL DEFAULT '0' COMMENT 'create_time',
                `update_time` int(11) UNSIGNED NOT NULL DEFAULT '0' COMMENT 'update_time',
                `published` enum('0','1') NOT NULL DEFAULT '0' COMMENT 'published',
                `deleted` enum('0','1') NOT NULL DEFAULT '0' COMMENT 'deleted',
                `readonly` enum('0','1') NOT NULL DEFAULT '0' COMMENT 'readonly'
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='menu';
        ");

        parent::up();
    }

    /**
     *
     */
    public function safeUp() {

        $this->execute("
            ALTER TABLE `" . $this->tableMenu . "`
                ADD PRIMARY KEY (`id`),
                ADD UNIQUE KEY `alias` (`alias`),
                ADD KEY `deleted` (`deleted`),
                ADD KEY `published` (`published`);
        ");

        $this->execute("
            ALTER TABLE `" . $this->tableMenu . "`
                MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'id', AUTO_INCREMENT=1;
        ");

        parent::safeUp();
    }

    /**
     *
     */
    public function safeDown() {
        $this->delete($this->tableMenu);
        $this->dropTable($this->tableMenu);

        parent::safeDown();
    }

}
