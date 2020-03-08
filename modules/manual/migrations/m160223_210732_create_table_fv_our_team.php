<?php

use thread\modules\manual\Manual;
use yii\db\Migration;

class m160223_210732_create_table_fv_our_team extends Migration
{
    /**
     *
     * @var type
     */
    public $tableManualAreastreatment = 'fv_manual_our_team';

    /**
     *
     * @var type
     */
    public $tableManualAreastreatmentLang = 'fv_manual_our_team_lang';

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
         CREATE TABLE `". $this->tableManualAreastreatment . "` (
              `id` int(11) unsigned NOT NULL COMMENT 'id',
              `image_link` varchar(255) DEFAULT NULL,
              `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT 'create_time',
              `update_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT 'update_time',
              `published` enum('0','1') NOT NULL DEFAULT '0' COMMENT 'published',
              `deleted` enum('0','1') NOT NULL DEFAULT '0' COMMENT 'deleted'
            ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='Наша команда';
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
