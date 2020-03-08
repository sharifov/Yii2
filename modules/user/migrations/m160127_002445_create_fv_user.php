<?php

use yii\db\Migration;
use thread\modules\user\User;

/**
 * Class m160127_002445_create_fv_user
 *
 * @package thread\modules\user
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c) 2015, Thread
 */
class m160127_002445_create_fv_user extends Migration {

    /**
     *
     * @var type
     */
    public $tableUser = 'fv_user';

    /**
     *
     * @var type
     */
    public $tableUserProfile = 'fv_user_profile';

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
            CREATE TABLE `".$this->tableUser."` (
                `id` int(11) UNSIGNED NOT NULL COMMENT 'id',
                `group_id` int(11) UNSIGNED NOT NULL DEFAULT '0' COMMENT 'group',
                `username` varchar(255) NOT NULL COMMENT 'username',
                `auth_key` varchar(32) NOT NULL COMMENT 'auth_key',
                `password_hash` varchar(255) NOT NULL COMMENT 'password_hash',
                `password_reset_token` varchar(255) DEFAULT NULL COMMENT 'password_reset_token',
                `email` varchar(255) NOT NULL COMMENT 'email',
                `role` smallint(6) NOT NULL DEFAULT '10' COMMENT 'role',
                `create_time` int(11) UNSIGNED NOT NULL DEFAULT '0' COMMENT 'create_time',
                `update_time` int(11) UNSIGNED NOT NULL DEFAULT '0' COMMENT 'update_time',
                `published` enum('0','1') NOT NULL DEFAULT '0' COMMENT 'published',
                `deleted` enum('0','1') NOT NULL DEFAULT '0' COMMENT 'deleted'
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='user';
        ");

        parent::up();
    }

    /**
     *
     */
    public function safeUp() {
        $this->execute("
            ALTER TABLE `" . $this->tableUser . "`
                ADD PRIMARY KEY (`id`),
                ADD UNIQUE KEY `username` (`username`),
                ADD KEY `published` (`published`),
                ADD KEY `deleted` (`deleted`),
                ADD KEY `group` (`group_id`);
        ");

        $this->execute("
            ALTER TABLE `" . $this->tableUser . "`
                MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'id', AUTO_INCREMENT=1;
        ");

        parent::safeUp();
    }

    /**
     *
     */
    public function safeDown() {
        $this->delete($this->tableUser);
        $this->dropTable($this->tableUser);

        parent::safeDown();
    }

}
