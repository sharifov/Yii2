<?php

use thread\modules\sanatorium\Sanatorium;
use yii\db\Migration;

class m160304_143004_create_table_fv_sanatorium_discount extends Migration
{

    /**
     *
     * @var type
     */
    public $tableSanatorium = 'fv_sanatorium_discount';

    /**
     *
     * @var type
     */
    public $tableSanatoriumLang = 'fv_sanatorium_discount_lang';

    /**
     *
     */
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
               `begin_discount` date DEFAULT NULL COMMENT 'Дата начала скидки',
               `end_discount`  date DEFAULT NULL COMMENT 'Дата окончания скидки',
               `prior_to`  int(11) NOT NULL COMMENT 'Дней до начала',
               `discount`  int(11) NOT NULL COMMENT 'Скидка',
              `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT 'create_time',
              `update_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT 'update_time',
              `published` enum('0','1') NOT NULL DEFAULT '0' COMMENT 'published',
              `deleted` enum('0','1') NOT NULL DEFAULT '0' COMMENT 'deleted'
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Скидки в санатории';
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
        $this->delete($this->tableNewsGroup);
        $this->dropTable($this->tableSanatorium);
        parent::safeDown();
    }
}
