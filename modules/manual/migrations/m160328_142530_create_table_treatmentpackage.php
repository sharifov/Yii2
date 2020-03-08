<?php

use thread\modules\manual\Manual;
use yii\db\Migration;

class m160328_142530_create_table_treatmentpackage extends Migration
{
    /**
     *
     * @var type
     */
    public $tableSanatorium = 'fv_manual_treatment_package';


    public function init()
    {

        $this->db = Manual::getDb();
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
              `value` float(12) NOT NULL DEFAULT '0' COMMENT 'значение пакета',
              `type` enum('0','1','3','7','10') NOT NULL DEFAULT '0' COMMENT 'тип пакета (на сколько дней рассчитан)',
              `position` int(11) NOT NULL DEFAULT '0' COMMENT 'position',
              `image_link` varchar(255) NOT NULL DEFAULT '' COMMENT 'image_link',
              `recalculated` enum('0','1') NOT NULL DEFAULT '0' COMMENT 'Пересчитывать?',

              `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT 'create_time',
              `update_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT 'update_time',
              `published` enum('0','1') NOT NULL DEFAULT '0' COMMENT 'published',
              `deleted` enum('0','1') NOT NULL DEFAULT '0' COMMENT 'deleted'
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Лечебные пакеты ';
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

        parent::safeUp();
    }

    /**
     *
     */
    public function safeDown()
    {
        $this->dropTable($this->tableSanatorium);
        parent::safeDown();
    }
}
