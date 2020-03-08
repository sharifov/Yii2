<?php

use thread\modules\manual\Manual;
use yii\db\Migration;

/**
 * Handles the creation for table `table_fv_manual_scenery_from_room`.
 */
class m160427_111816_create_table_fv_manual_scenery_from_room extends Migration
{
    /**
     *
     * @var type
     */
    public $tableManualAreastreatment = 'fv_manual_scenery_from_room';

    /**
     *
     * @var type
     */
    public $tableManualAreastreatmentLang = 'fv_manual_scenery_from_room_lang';

    /**
     *
     */
    public function init() {

        $this->db = Manual::getDb();
        parent::init();
    }


    /**
     *
     */
    public function up() {
        $this->execute("
          CREATE TABLE `". $this->tableManualAreastreatment ."` (
              `id` int(11) unsigned NOT NULL COMMENT 'id',
              `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT 'create_time',
              `update_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT 'update_time',
              `published` enum('0','1') NOT NULL DEFAULT '0' COMMENT 'published',
              `deleted` enum('0','1') NOT NULL DEFAULT '0' COMMENT 'deleted'
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Вид из номера';
        ");

        parent::up();
    }

    /**
     *
     */
    public function safeUp() {

        $this->execute("
            ALTER TABLE `". $this->tableManualAreastreatment ."`
                  ADD PRIMARY KEY (`id`),
                  ADD KEY `deleted` (`deleted`),
                  ADD KEY `published` (`published`)
        ");

        $this->execute("
            ALTER TABLE `". $this->tableManualAreastreatment ."`
                MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'id', AUTO_INCREMENT=1;
        ");

        parent::safeUp();
    }

    /**
     *
     */
    public function safeDown() {
        $this->delete($this->tableManualAreastreatment);
        $this->dropTable($this->tableManualAreastreatment);

        parent::safeDown();
    }
}
