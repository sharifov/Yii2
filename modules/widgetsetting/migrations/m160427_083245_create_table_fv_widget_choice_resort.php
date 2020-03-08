<?php

use admin\modules\widgetsetting\Widgetsetting;
use yii\db\Migration;

/**
 * Handles the creation for table `table_fv_widget_choice_resort`.
 */
class m160427_083245_create_table_fv_widget_choice_resort extends Migration
{
    public $tableName = 'fv_widget_choice_resort';
    public $countyTableName = 'fv_widget_choice_resort_lang';


    public function init() {

        $this->db = Widgetsetting::getDb();
        parent::init();
    }

    public function up() {
        $this->execute("
        CREATE TABLE `" . $this->tableName . "` (
              `id` int(11) unsigned NOT NULL COMMENT 'id',

              `alias` varchar(255)  COMMENT 'alias',
              `city_id` int(11) unsigned NOT NULL COMMENT 'city_id',
              `country_id` int(11) unsigned NOT NULL COMMENT 'country_id',

              `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT 'create_time',
              `update_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT 'update_time',
              `published` enum('0','1') NOT NULL DEFAULT '0' COMMENT 'published',
              `deleted` enum('0','1') NOT NULL DEFAULT '0' COMMENT 'deleted'
            ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='Выбор курорта';
        ");

        parent::up();
    }

    public function safeUp() {

        $this->execute("
            ALTER TABLE `" . $this->tableName . "`
               ADD PRIMARY KEY (`id`),
               ADD KEY `deleted` (`deleted`),
               ADD KEY `published` (`published`)
        ");

        $this->execute("
            ALTER TABLE `". $this->tableName ."`
                MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'id', AUTO_INCREMENT=1;
        ");

        $this->addForeignKey('fv_widget_choice_resort_city_id_idfk_1', $this->tableName, 'city_id', 'fv_location_city', 'id', 'CASCADE');
        $this->addForeignKey('fv_widget_choice_resort_country_id_idfk_1', $this->tableName, 'country_id', 'fv_location_country', 'id', 'CASCADE');


        parent::safeUp();
    }

    public function safeDown() {
        $this->delete($this->tableName);
        $this->dropTable($this->tableName);

        parent::safeDown();
    }
}
