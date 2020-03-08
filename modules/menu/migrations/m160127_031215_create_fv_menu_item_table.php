<?php

use yii\db\Migration;
use thread\modules\menu\Menu;

/**
 * Class m160127_031215_create_fv_menu_item_table
 *
 * @package thread\modules\menu
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c) 2015, Thread
 */
class m160127_031215_create_fv_menu_item_table extends Migration {

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
     * @var type
     */
    public $tableMenuItem = 'fv_menu_item';

    /**
     *
     * @var type
     */
    public $tableMenuItemLang = 'fv_menu_item_lang';

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
            CREATE TABLE `" . $this->tableMenuItem . "` (
                `id` int(11) UNSIGNED NOT NULL COMMENT 'id',
                `group_id` int(11) UNSIGNED NOT NULL COMMENT 'group',
                `type` enum('normal','divider','header') NOT NULL DEFAULT 'normal' COMMENT 'type',
                `link` varchar(255) NOT NULL DEFAULT '' COMMENT 'link',
                `position` int(11) UNSIGNED NOT NULL DEFAULT '0' COMMENT 'position',
                `create_time` int(11) UNSIGNED NOT NULL DEFAULT '0' COMMENT 'create_time',
                `update_time` int(11) UNSIGNED NOT NULL DEFAULT '0' COMMENT 'update_time',
                `published` enum('0','1') NOT NULL DEFAULT '0' COMMENT 'published',
                `deleted` enum('0','1') NOT NULL DEFAULT '0' COMMENT 'deleted',
                `link_type` enum('external','internal') NOT NULL DEFAULT 'external' COMMENT 'link_type',
                `link_target` enum('_blank','_self') NOT NULL DEFAULT '_blank' COMMENT 'link_target',
                `internal_source` enum('page') NOT NULL DEFAULT 'page' COMMENT 'internal_source',
                `internal_source_id` int(11) UNSIGNED NOT NULL COMMENT 'internal_source_id'
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='menu item';
        ");

        parent::up();
    }

    /**
     *
     */
    public function safeUp() {

        $this->execute("
            ALTER TABLE `" . $this->tableMenuItem . "`
                ADD PRIMARY KEY (`id`),
                ADD KEY `deleted` (`deleted`),
                ADD KEY `published` (`published`),
                ADD KEY `group_id` (`group_id`);
        ");

        $this->execute("
            ALTER TABLE `" . $this->tableMenuItem . "`
                MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'id', AUTO_INCREMENT=1;
        ");

        $this->execute("
            ALTER TABLE `" . $this->tableMenuItem . "`
                ADD CONSTRAINT `" . $this->tableMenuItem . "_ibfk_1` FOREIGN KEY (`group_id`) REFERENCES `" . $this->tableMenu . "` (`id`) ON DELETE CASCADE;
        ");

        parent::safeUp();
    }

    /**
     *
     */
    public function safeDown() {
        $this->delete($this->tableMenuItem);
        $this->dropTable($this->tableMenuItem);

        parent::safeDown();
    }

}
