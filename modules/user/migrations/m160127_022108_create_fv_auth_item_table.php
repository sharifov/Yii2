<?php

use yii\db\Migration;
use thread\modules\user\User;

/**
 * Class m160127_022108_create_fv_auth_item_table
 *
 * @package thread\modules\user
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c) 2015, Thread
 */
class m160127_022108_create_fv_auth_item_table extends Migration {

    /**
     *
     * @var type
     */
    public $tableAuthItem = 'fv_auth_item';

    /**
     *
     * @var type
     */
    public $tableAuthRule = 'fv_auth_rule';

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
            CREATE TABLE `" . $this->tableAuthItem . "` (
                `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
                `type` int(11) NOT NULL,
                `description` text COLLATE utf8_unicode_ci,
                `rule_name` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
                `data` text COLLATE utf8_unicode_ci,
                `created_at` int(11) DEFAULT NULL,
                `updated_at` int(11) DEFAULT NULL
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
        ");

        parent::up();
    }

    /**
     *
     */
    public function safeUp() {

        $this->execute("
            ALTER TABLE `" . $this->tableAuthItem . "`
                ADD PRIMARY KEY (`name`),
                ADD KEY `rule_name` (`rule_name`),
                ADD KEY `idx-auth_item-type` (`type`);
        ");

        $this->execute("
            ALTER TABLE `" . $this->tableAuthItem . "`
                ADD CONSTRAINT `" . $this->tableAuthItem . "_ibfk_1` FOREIGN KEY (`rule_name`) REFERENCES `" . $this->tableAuthRule . "` (`name`) ON DELETE SET NULL ON UPDATE CASCADE;
        ");

        $this->execute("
            INSERT INTO `" . $this->tableAuthItem . "` (`name`, `type`, `description`, `rule_name`, `data`, `created_at`, `updated_at`) VALUES
                ('admin', 1, 'admin', NULL, NULL, 1434804210, 1434804210),
                ('admin_company', 1, 'company administrator', NULL, NULL, 1434804210, 1434804210),
                ('admin_sanatorium', 1, 'sanatorium administrator', NULL, NULL, 1434804210, 1434804210),
                ('worker_sanatorium', 1, 'sanatorium worker', NULL, NULL, 1434804210, 1434804210),
                ('user', 1, 'user', NULL, NULL, 1434804210, 1434804210);
        ");

        parent::safeUp();
    }

    /**
     *
     */
    public function safeDown() {
        $this->delete($this->tableAuthItem);
        $this->dropTable($this->tableAuthItem);

        parent::safeDown();
    }

}
