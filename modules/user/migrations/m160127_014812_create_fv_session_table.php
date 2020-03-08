<?php

use yii\db\Migration;
use thread\modules\user\User;

/**
 * Class m160127_014812_create_fv_session_table
 *
 * @package thread\modules\user
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c) 2015, Thread
 */
class m160127_014812_create_fv_session_table extends Migration {

    /**
     *
     * @var type
     */
    public $tableSession = 'fv_session';

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
            CREATE TABLE `" . $this->tableSession . "` (
                `id` char(40) NOT NULL,
                `expire` int(11) DEFAULT NULL,
                `data` blob
                ) ENGINE=InnoDB DEFAULT CHARSET=latin1;
        ");

        parent::up();
    }

    /**
     *
     */
    public function safeUp() {
        $this->execute("
            ALTER TABLE `" . $this->tableSession . "`
                ADD PRIMARY KEY (`id`);
        ");

        parent::safeUp();
    }

    /**
     *
     */
    public function safeDown() {
        $this->delete($this->tableSession);
        $this->dropTable($this->tableSession);

        parent::safeDown();
    }

}
