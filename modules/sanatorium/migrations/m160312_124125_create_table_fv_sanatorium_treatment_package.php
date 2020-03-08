<?php

use thread\modules\sanatorium\Sanatorium;
use yii\db\Migration;

class m160312_124125_create_table_fv_sanatorium_treatment_package extends Migration
{
    /**
     *
     * @var type
     */
    public $tableSanatorium = 'fv_sanatorium_treatment_package';


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
          CREATE TABLE `" . $this->tableSanatorium . "` (
              `id` int(11) unsigned NOT NULL  COMMENT 'id',
              `sanatorium_id` int(11) unsigned DEFAULT NULL COMMENT 'санаторий_id',

              `value` float(12) NOT NULL DEFAULT '0' COMMENT 'значение пакета',
              `type` enum('0','1','3','7','10') NOT NULL DEFAULT '0' COMMENT 'тип пакета (на сколько дней рассчитан)',
              `position` int(11) NOT NULL DEFAULT '0' COMMENT 'position',

              `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT 'create_time',
              `update_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT 'update_time',
              `published` enum('0','1') NOT NULL DEFAULT '0' COMMENT 'published',
              `deleted` enum('0','1') NOT NULL DEFAULT '0' COMMENT 'deleted'
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Лечебные пакеты санатория';
        ");

        parent::up();
    }

    /**
     *
     */
    public function safeUp()
    {

        $this->execute("
            ALTER TABLE `" . $this->tableSanatorium . "`
                   ADD PRIMARY KEY (`id`),
                   ADD KEY `deleted` (`deleted`),
                   ADD KEY `published` (`published`)
        ");

        $this->execute("
            ALTER TABLE `" . $this->tableSanatorium . "`
                MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'id', AUTO_INCREMENT=1;
        ");

        $this->addForeignKey('fv_sanatorium_treatment_package_fv_sanatorium_id_ibfk_1', $this->tableSanatorium, 'sanatorium_id', 'fv_sanatorium_sanatoriums', 'id', 'CASCADE');

        parent::safeUp();
    }

    /**
     *
     */
    public function safeDown()
    {
        $this->delete($this->tableNewsGroup);
        $this->dropTable($this->tableSanatorium);
        parent::safeDown();
    }
}
