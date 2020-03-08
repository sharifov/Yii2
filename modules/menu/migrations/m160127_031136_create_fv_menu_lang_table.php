<?php

use yii\db\Migration;
use thread\modules\menu\Menu;

/**
 * 
 * Class m160127_031136_create_fv_menu_lang_table
 *
 * @package thread\modules\menu
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c) 2015, Thread
 */
class m160127_031136_create_fv_menu_lang_table extends Migration {

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
            CREATE TABLE `" . $this->tableMenuLang . "` (
                `rid` int(11) UNSIGNED NOT NULL COMMENT 'rid',
                `lang` varchar(5) NOT NULL COMMENT 'lang',
                `title` varchar(255) NOT NULL COMMENT 'title'
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='menu lang';
        ");

        parent::up();
    }

    /**
     *
     */
    public function safeUp() {

        $this->execute("
            ALTER TABLE `" . $this->tableMenuLang . "`
                ADD UNIQUE KEY `rid` (`rid`,`lang`);
        ");

        $this->execute("
            ALTER TABLE `" . $this->tableMenuLang . "`
                ADD CONSTRAINT `" . $this->tableMenuLang . "_ibfk_1` FOREIGN KEY (`rid`) REFERENCES `" . $this->tableMenu . "` (`id`) ON DELETE CASCADE;
        ");

        parent::safeUp();
    }

    /**
     *
     */
    public function safeDown() {
        $this->delete($this->tableMenuLang);
        $this->dropTable($this->tableMenuLang);

        parent::safeDown();
    }

}
