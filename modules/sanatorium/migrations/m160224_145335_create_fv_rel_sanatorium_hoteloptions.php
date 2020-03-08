<?php

use yii\db\Migration;
use thread\modules\sanatorium\Sanatorium;

/**
 * Class m160224_145335_create_fv_rel_sanatorium_hoteloptions
 *
 * @package thread\modules\sanatorium
 */
class m160224_145335_create_fv_rel_sanatorium_hoteloptions extends Migration
{
    /**
     *
     * @var type
     */
    public $table = 'fv_sanatorium_rel_hoteloptions';

    /**
     *
     */
    public function init()
    {
        $this->db = Sanatorium::getDb();
        parent::init();
    }

    /**
     *
     */
    public function up()
    {
        $this->execute("
            CREATE TABLE `" . $this->table . "` (
                `sanatorium_id` int(11) unsigned NOT NULL,
                `hoteloptions_id` int(11) unsigned NOT NULL
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
        ");

        parent::up();
    }

    /**
     *
     */
    public function safeUp()
    {
        $this->execute("
            ALTER TABLE `" . $this->table . "`
                ADD PRIMARY KEY (`sanatorium_id`,`hoteloptions_id`),
                ADD UNIQUE KEY `index` (`hoteloptions_id`,`sanatorium_id`),
                ADD KEY `hoteloptions_id` (`hoteloptions_id`),
                ADD KEY `sanatorium_id` (`sanatorium_id`);
        ");

        parent::safeUp();
    }

    /**
     *
     */
    public function safeDown()
    {
        $this->delete($this->table);
        $this->dropTable($this->table);

        parent::safeDown();
    }
}
