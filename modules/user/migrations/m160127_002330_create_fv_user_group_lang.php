<?php

use yii\db\Migration;
use thread\modules\user\User;

/**
 * Class m160127_002330_create_fv_user_group_lang
 *
 * @package thread\modules\user
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c) 2015, Thread
 */
class m160127_002330_create_fv_user_group_lang extends Migration {

    /**
     *
     * @var type
     */
    public $tableUserGroup = 'fv_user_group';

    /**
     *
     * @var type
     */
    public $tableUserGroupLang = 'fv_user_group_lang';

    /**
     *
     */
    public function init() {

        $this->db = User::getDb();
        parent::init();
    }

    /**
     *
     */
    public function up() {
        $this->execute("
            CREATE TABLE `" . $this->tableUserGroupLang . "` (
                `rid` int(11) UNSIGNED NOT NULL COMMENT 'rid',
                `lang` varchar(5) NOT NULL COMMENT 'lang',
                `title` varchar(255) NOT NULL COMMENT 'title'
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='user group lang';
        ");

        parent::up();
    }

    /**
     *
     */
    public function safeUp() {
        $this->execute("
            ALTER TABLE `" . $this->tableUserGroupLang . "`
                ADD UNIQUE KEY `rid` (`rid`,`lang`);
        ");

        $this->execute("
            ALTER TABLE `" . $this->tableUserGroupLang . "`
                ADD CONSTRAINT `" . $this->tableUserGroupLang . "_ibfk_1` FOREIGN KEY (`rid`) REFERENCES `" . $this->tableUserGroup . "` (`id`) ON DELETE CASCADE;
        ");

        parent::safeUp();
    }

    /**
     *
     */
    public function safeDown() {
        $this->delete($this->tableUserGroupLang);
        $this->dropTable($this->tableUserGroupLang);

        parent::safeDown();
    }

}
