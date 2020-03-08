<?php

use yii\db\Migration;
use thread\modules\sanatorium\Sanatorium;

class m160305_094821_create_table_fv_sanatorium_penalties extends Migration
{
    /**
     *
     * @var type
     */
    public $tableSanatorium = 'fv_sanatorium_penalties';

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
               `sanatorium_id` int(11) unsigned DEFAULT NULL COMMENT 'санаторий_id',
               `range_1`  int(11) NOT NULL DEFAULT 0 COMMENT 'Санкции 0-2 дн. до приезда',
               `range_2`  int(11) NOT NULL DEFAULT 0 COMMENT 'Санкции 3-7 дн. до приезда',
               `range_3`  int(11) NOT NULL DEFAULT 0 COMMENT 'Санкции 8-14 дн. до приезда',
               `range_4`  int(11) NOT NULL DEFAULT 0 COMMENT 'Санкции 15-21 дн. до приезда',
               `range_5`  int(11) NOT NULL DEFAULT 0 COMMENT 'Санкции 22-28 дн. до приезда',
               `range_6`  int(11) NOT NULL DEFAULT 0 COMMENT 'Санкции 29-... дн. до приезда',
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

        $this->addForeignKey('fv_sanatorium_id_ibfk_1', 'fv_sanatorium_penalties', 'sanatorium_id', 'fv_sanatorium_sanatoriums', 'id', 'CASCADE');

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
