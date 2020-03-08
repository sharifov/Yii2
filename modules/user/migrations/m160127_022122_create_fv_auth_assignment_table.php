<?php

use yii\db\Migration;
use thread\modules\user\User;

/**
 * Class m160127_022122_create_fv_auth_assignment_table
 *
 * @package thread\modules\user
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c) 2015, Thread
 */
class m160127_022122_create_fv_auth_assignment_table extends Migration {

    /**
     *
     * @var type
     */
    public $tableAuthAssigment = 'fv_auth_assignment';

    /**
     *
     * @var type
     */
    public $tableAuthItem = 'fv_auth_item';

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
            CREATE TABLE `" . $this->tableAuthAssigment . "` (
                `item_name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
                `user_id` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
                `created_at` int(11) DEFAULT NULL
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
        ");

        parent::up();
    }

    /**
     *
     */
    public function safeUp() {

        $this->execute("
            ALTER TABLE `" . $this->tableAuthAssigment . "`
                ADD PRIMARY KEY (`item_name`,`user_id`);
        ");

        $this->execute("
            ALTER TABLE `" . $this->tableAuthAssigment . "`
            ADD CONSTRAINT `fv_auth_assignment_ibfk_1` FOREIGN KEY (`item_name`) REFERENCES `" . $this->tableAuthItem . "` (`name`) ON DELETE CASCADE ON UPDATE CASCADE;
        ");

        $this->execute("
            INSERT INTO `" . $this->tableAuthAssigment . "` (`item_name`, `user_id`, `created_at`) VALUES
                ('admin', '1', 1453653591),
                ('admin_company', '2', 1455183254),
                ('admin_sanatorium', '6', 1455183344);
        ");

        parent::safeUp();
    }

    /**
     *
     */
    public function safeDown() {
        $this->delete($this->tableAuthAssigment);
        $this->dropTable($this->tableAuthAssigment);

        parent::safeDown();
    }

}
