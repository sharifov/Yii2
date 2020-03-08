<?php

use thread\modules\manual\Manual;
use yii\db\Migration;

class m160322_082929_create_table_fv_manual_mailing_list extends Migration
{
    public $tableManualMain = 'fv_manual_mailing_list';

    public function init() {

        $this->db = Manual::getDb();
        parent::init();
    }

    /**
     *
     */
    public function up() {
        $this->execute("
         CREATE TABLE `". $this->tableManualMain ."` (
              `id` int(11) unsigned NOT NULL  COMMENT 'id',
              `email` varchar(255) NOT NULL DEFAULT '' COMMENT 'email',
              `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT 'create_time',
              `update_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT 'update_time',
              `published` enum('0','1') NOT NULL DEFAULT '0' COMMENT 'published',
              `deleted` enum('0','1') NOT NULL DEFAULT '0' COMMENT 'deleted'

            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Удобство номера';
        ");

        parent::up();
    }

    /**
     *
     */
    public function safeUp() {

        $this->execute("
            ALTER TABLE `". $this->tableManualMain ."`
                  ADD PRIMARY KEY (`id`),
                  ADD KEY `deleted` (`deleted`),
                  ADD KEY `published` (`published`)
        ");

        $this->execute("
            ALTER TABLE `". $this->tableManualMain ."`
                MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'id', AUTO_INCREMENT=1;
        ");

        parent::safeUp();
    }

    /**
     *
     */
    public function safeDown() {
        $this->delete($this->tableManualMain);
        $this->dropTable($this->tableManualMain);

        parent::safeDown();
    }
}
