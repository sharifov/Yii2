<?php

use thread\modules\sanatorium\Sanatorium;
use yii\db\Migration;

/**
 * Handles the creation for table `table_discount_days_stay`.
 */
class m160517_132648_create_table_discount_days_stay extends Migration
{
    /**
     *
     * @var type
     */
    public $tableSanatorium = 'fv_sanatorium_discount_days_stay';


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
               `sanatorium_id`  int(11) unsigned NOT NULL COMMENT 'санаторий',

               `start_day`  int(11) unsigned NOT NULL COMMENT 'дата начала промежутка скиндки',
               `finish_day`  int(11) unsigned NOT NULL COMMENT 'дата окончания промежутка скиндки',
               `discount`  int(11) unsigned NOT NULL COMMENT 'в процентах',

               `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT 'create_time',
               `update_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT 'update_time',
               `published` enum('0','1') NOT NULL DEFAULT '0' COMMENT 'published',
               `deleted` enum('0','1') NOT NULL DEFAULT '0' COMMENT 'deleted'

            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Скидки в санатории! на количество забронированных дней ';
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


        $this->addForeignKey($this->tableSanatorium .'__sanatoriums_ibfk_1', $this->tableSanatorium , 'sanatorium_id', 'fv_sanatorium_sanatoriums', 'id', 'CASCADE');

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
