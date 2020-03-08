<?php

use yii\db\Migration;
use thread\modules\user\User;

/**
 * Class m160127_002323_create_fv_user_group
 *
 * @package thread\modules\user
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c) 2015, Thread
 */
class m160127_002323_create_fv_user_group extends Migration {

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
            CREATE TABLE `" . $this->tableUserGroup . "` (
                `id` int(11) UNSIGNED NOT NULL COMMENT 'id',
                `alias` varchar(255) NOT NULL COMMENT 'alias',
                `role` varchar(50) NOT NULL DEFAULT 'guest' COMMENT 'role',
                `create_time` int(11) UNSIGNED NOT NULL DEFAULT '0' COMMENT 'create_time',
                `update_time` int(11) UNSIGNED NOT NULL DEFAULT '0' COMMENT 'update_time',
                `published` enum('0','1') NOT NULL DEFAULT '0' COMMENT 'published',
                `deleted` enum('0','1') NOT NULL DEFAULT '0' COMMENT 'deleted'
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='user group';
        ");

        parent::up();
    }

    /**
     *
     */
    public function safeUp() {
        $this->execute("
            ALTER TABLE `" . $this->tableUserGroup . "`
                ADD PRIMARY KEY (`id`),
                ADD UNIQUE KEY `alias` (`alias`),
                ADD KEY `deleted` (`deleted`),
                ADD KEY `published` (`published`);
        ");

        $this->execute("
            ALTER TABLE `" . $this->tableUserGroup . "`
                MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'id', AUTO_INCREMENT=1;
        ");

        parent::safeUp();
    }

    /**
     *
     */
    public function safeDown() {
        $this->delete($this->tableUserGroup);
        $this->dropTable($this->tableUserGroup);

        parent::safeDown();
    }

}
