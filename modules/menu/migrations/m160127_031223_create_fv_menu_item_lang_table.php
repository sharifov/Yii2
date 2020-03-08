<?php

use yii\db\Migration;
use thread\modules\menu\Menu;

/**
 * Class m160127_031223_create_fv_menu_item_lang_table
 *
 * @package thread\modules\menu
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c) 2015, Thread
 */
class m160127_031223_create_fv_menu_item_lang_table extends Migration {

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
            CREATE TABLE `" . $this->tableMenuItemLang . "` (
                `rid` int(11) UNSIGNED NOT NULL COMMENT 'rid',
                `lang` varchar(5) NOT NULL COMMENT 'lang',
                `title` varchar(255) NOT NULL COMMENT 'title'
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='menu item lang';
        ");

        parent::up();
    }

    /**
     *
     */
    public function safeUp() {

        $this->execute("
            ALTER TABLE `" . $this->tableMenuItemLang . "`
                ADD UNIQUE KEY `rid` (`rid`,`lang`);
        ");

        $this->execute("
            ALTER TABLE `" . $this->tableMenuItemLang . "`
                ADD CONSTRAINT `fv_menu_item_lang_ibfk_1` FOREIGN KEY (`rid`) REFERENCES `" . $this->tableMenuItem . "` (`id`) ON DELETE CASCADE;
        ");

        parent::safeUp();
    }

    /**
     *
     */
    public function safeDown() {
        $this->delete($this->tableMenuItemLang);
        $this->dropTable($this->tableMenuItemLang);

        parent::safeDown();
    }

}
