<?php

use yii\db\Migration;
use thread\modules\user\User;

/**
 * Class m160127_002500_create_fv_user_profile
 *
 * @package thread\modules\user
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c) 2015, Thread
 */
class m160127_002500_create_fv_user_profile extends Migration {

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
            CREATE TABLE `" . $this->tableUserProfile . "` (
                `id` int(11) UNSIGNED NOT NULL COMMENT 'id',
                `company_id` int(11) UNSIGNED NOT NULL COMMENT 'company_id',
                `user_id` int(11) UNSIGNED NOT NULL COMMENT 'user_id',
                `name` varchar(255) NOT NULL DEFAULT 'name' COMMENT 'name',
                `surname` varchar(255) NOT NULL DEFAULT 'surname' COMMENT 'surname',
                `image_link` varchar(255) NOT NULL DEFAULT '' COMMENT 'image_link',
                `preferred_language` varchar(5) NOT NULL DEFAULT 'en-EN' COMMENT 'preferred_language',
                `create_time` int(11) UNSIGNED NOT NULL DEFAULT '0' COMMENT 'create_time',
                `update_time` int(11) UNSIGNED NOT NULL DEFAULT '0' COMMENT 'update_time'
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='user profile';
        ");

        parent::up();
    }

    /**
     *
     */
    public function safeUp() {
        $this->execute("
            ALTER TABLE `" . $this->tableUserProfile . "`
            ADD PRIMARY KEY (`id`),
            ADD UNIQUE KEY `user_id` (`user_id`),
            ADD KEY `name` (`name`),
            ADD KEY `surname` (`surname`);
        ");

        $this->execute("
            ALTER TABLE `" . $this->tableUserProfile . "`
                MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'id', AUTO_INCREMENT=1;
        ");

        $this->execute("
            ALTER TABLE `" . $this->tableUserProfile . "`
                ADD CONSTRAINT `" . $this->tableUserProfile . "_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `" . $this->tableUser . "` (`id`) ON DELETE CASCADE;
        ");

        parent::safeUp();
    }

    /**
     *
     */
    public function safeDown() {
        $this->delete($this->tableUserProfile);
        $this->dropTable($this->tableUserProfile);

        parent::safeDown();
    }

}
