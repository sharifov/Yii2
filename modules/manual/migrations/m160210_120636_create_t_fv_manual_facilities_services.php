<?php

use yii\db\Migration;
use thread\modules\manual\Manual;

class m160210_120636_create_t_fv_manual_facilities_services extends Migration
{
    /**
     *
     * @var type
     */
    public $tableManualMain= 'fv_manual_facilities_services';

    /**
     *
     * @var type
     */
    public $tableManualLang = 'fv_manual_facilities_services_lang';

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
         CREATE TABLE `". $this->tableManualMain ."` (
              `id` int(11) unsigned NOT NULL  COMMENT 'id',
              `alias` varchar(255) DEFAULT '' COMMENT 'alias',
              `sort` int(11) unsigned DEFAULT '0' COMMENT 'sort',
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
                  ADD UNIQUE KEY `alias` (`alias`),
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
