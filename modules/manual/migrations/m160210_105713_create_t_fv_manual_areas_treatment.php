<?php

use yii\db\Migration;
use thread\modules\manual\Manual;

class m160210_105713_create_t_fv_manual_areas_treatment extends Migration
{
    /**
     *
     * @var type
     */
    public $tableManualAreastreatment = 'fv_manual_areas_treatment';

    /**
     *
     * @var type
     */
    public $tableManualAreastreatmentLang = 'fv_manual_areas_treatment_lang';

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
              `group_id` int(11) unsigned DEFAULT NULL COMMENT 'group',
              `image_link` varchar(255) DEFAULT NULL,
              `alias` varchar(255) DEFAULT '' COMMENT 'alias',
              `sort` int(11) unsigned DEFAULT '0' COMMENT 'sort',
              `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT 'create_time',
              `update_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT 'update_time',
              `published` enum('0','1') NOT NULL DEFAULT '0' COMMENT 'published',
              `deleted` enum('0','1') NOT NULL DEFAULT '0' COMMENT 'deleted'
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Направления лечения';
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
                  ADD UNIQUE KEY `alias` (`alias`),
                  ADD KEY `deleted` (`deleted`),
                  ADD KEY `published` (`published`),
                  ADD KEY `group` (`group_id`)
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
