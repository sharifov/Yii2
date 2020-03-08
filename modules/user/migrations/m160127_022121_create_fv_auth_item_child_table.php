<?php

use yii\db\Migration;
use thread\modules\user\User;

/**
 * Class m160127_022121_create_fv_auth_item_child_table
 *
 * @package thread\modules\user
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c) 2015, Thread
 */
class m160127_022121_create_fv_auth_item_child_table extends Migration {

    /**
     *
     * @var type
     */
    public $tableAuthItem = 'fv_auth_item';

    /**
     *
     * @var type
     */
    public $tableAuthItemChild = 'fv_auth_item_child';

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
            CREATE TABLE `" . $this->tableAuthItemChild . "` (
                `parent` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
                `child` varchar(64) COLLATE utf8_unicode_ci NOT NULL
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
        ");

        parent::up();
    }

    /**
     *
     */
    public function safeUp() {

        $this->execute("
            ALTER TABLE `" . $this->tableAuthItemChild . "`
                ADD PRIMARY KEY (`parent`,`child`),
                ADD KEY `child` (`child`);
        ");

        $this->execute("
            ALTER TABLE `" . $this->tableAuthItemChild . "`
                ADD CONSTRAINT `" . $this->tableAuthItemChild . "_ibfk_1` FOREIGN KEY (`parent`) REFERENCES `" . $this->tableAuthItem . "` (`name`) ON DELETE CASCADE ON UPDATE CASCADE,
                ADD CONSTRAINT `" . $this->tableAuthItemChild . "_ibfk_2` FOREIGN KEY (`child`) REFERENCES `" . $this->tableAuthItem . "` (`name`) ON DELETE CASCADE ON UPDATE CASCADE;
        ");

        parent::safeUp();
    }

    /**
     *
     */
    public function safeDown() {
        $this->delete($this->tableAuthItemChild);
        $this->dropTable($this->tableAuthItemChild);

        parent::safeDown();
    }

}
