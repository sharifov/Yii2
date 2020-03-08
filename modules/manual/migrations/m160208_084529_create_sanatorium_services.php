<?php

use yii\db\Migration;
use thread\modules\manual\Manual;

class m160208_084529_create_sanatorium_services extends Migration
{
    public $tableSanatoriumServices = 'fv_manual_services';
    /**
     *
     * @var type
     */
    public $tableSanatoriumServicesLang = 'fv_manual_services_lang';

    public function init() {

        $this->db = Manual::getDb();
        parent::init();
    }

    public function up() {
        $this->execute("
        CREATE TABLE `". $this->tableSanatoriumServices  ."` (
          `id` int(11) unsigned NOT NULL  COMMENT 'id',
          `alias` varchar(255) DEFAULT '' COMMENT 'alias',
          `image_link` varchar(255) DEFAULT NULL,
          `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT 'create_time',
          `update_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT 'update_time',
          `published` enum('0','1') NOT NULL DEFAULT '0' COMMENT 'published',
          `deleted` enum('0','1') NOT NULL DEFAULT '0' COMMENT 'deleted'
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Услуги санатория';
        ");

        parent::up();
    }

    public function safeUp() {

        $this->execute("
            ALTER TABLE `" . $this->tableSanatoriumServices . "`
                ADD PRIMARY KEY (`id`),
                ADD UNIQUE KEY `alias` (`alias`),
                ADD KEY `deleted` (`deleted`),
                ADD KEY `published` (`published`);
        ");

        $this->execute("
            ALTER TABLE `". $this->tableSanatoriumServices ."`
                MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'id', AUTO_INCREMENT=1;
        ");


        parent::safeUp();
    }

    public function safeDown() {
        $this->delete($this->tableSanatoriumServices );
        $this->dropTable($this->tableSanatoriumServices );

        parent::safeDown();
    }
}
