<?php

use yii\db\Migration;
use thread\modules\manual\Manual;

class m160215_101932_add_table_fv_manual_consultants extends Migration
{
    /**
     *
     * @var type
     */
    public $tableManualMain= 'fv_manual_consultants';

    /**
     *
     * @var type
     */
    public $tableManualLang = 'fv_manual_consultants_lang';

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
        CREATE TABLE `". $this->tableManualMain."` (
            `id` int(11) unsigned NOT NULL COMMENT 'id',
            `alias` varchar(255) DEFAULT '' COMMENT 'alias',
            `image_link` varchar(255) DEFAULT NULL COMMENT 'image_link',
            `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT 'create_time',
            `update_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT 'update_time',
            `published` enum('0','1') NOT NULL DEFAULT '0' COMMENT 'published',
            `deleted` enum('0','1') NOT NULL DEFAULT '0' COMMENT 'deleted'
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Консультаны';
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
