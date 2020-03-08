<?php

use yii\db\Migration;
use thread\modules\page\Page;

/**
 * Class m160126_232541_create_fv_page_lang_table
 *
 * @package thread\modules\page
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c) 2015, Thread
 */
class m160126_232541_create_fv_page_lang_table extends Migration {

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
            CREATE TABLE `" . $this->tablePageLang . "` (
                `rid` int(11) UNSIGNED NOT NULL COMMENT 'rid',
                `lang` varchar(5) NOT NULL COMMENT 'lang',
                `title` varchar(255) NOT NULL COMMENT 'title',
                `content` text NOT NULL COMMENT 'content'
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='page lang';
        ");

        parent::up();
    }

    /**
     *
     */
    public function safeUp() {
        $this->execute("
            ALTER TABLE `" . $this->tablePageLang . "`
                ADD UNIQUE KEY `rid` (`rid`,`lang`);
        ");

        $this->execute("
            ALTER TABLE `" . $this->tablePageLang . "`
                ADD CONSTRAINT `" . $this->tablePageLang . "_ibfk_1` FOREIGN KEY (`rid`) REFERENCES `" . $this->tablePage . "` (`id`) ON DELETE CASCADE;
        ");

        parent::safeUp();
    }

    /**
     *
     */
    public function safeDown() {
        $this->delete($this->tablePageLang);
        $this->dropTable($this->tablePageLang);

        parent::safeDown();
    }

}
