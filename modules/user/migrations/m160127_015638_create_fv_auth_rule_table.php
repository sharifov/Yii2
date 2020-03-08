<?php

use yii\db\Migration;
use thread\modules\user\User;

/**
 * Class m160127_015638_create_fv_auth_rule_table
 *
 * @package thread\modules\user
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c) 2015, Thread
 */
class m160127_015638_create_fv_auth_rule_table extends Migration {

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
            CREATE TABLE `" . $this->tableAuthRule . "` (
                `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
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
            ALTER TABLE `" . $this->tableAuthRule . "`
                ADD PRIMARY KEY (`name`);
        ");

        parent::safeUp();
    }

    /**
     *
     */
    public function safeDown() {
        $this->delete($this->tableAuthRule);
        $this->dropTable($this->tableAuthRule);

        parent::safeDown();
    }

}
