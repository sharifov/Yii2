<?php

use yii\db\Migration;
use thread\modules\sanatorium\Sanatorium;

class m160311_131705_create_table_fv_sanatorium_prices extends Migration
{
    /**
     *
     * @var type
     */
    public $tableSanatorium = 'fv_sanatorium_prices';


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
              `sanatorium_room_type_id` int(11) unsigned NOT NULL COMMENT 'тип номера санатория',
              `manual_room_id` int(11) unsigned NOT NULL COMMENT 'Вид номера',
              `price` decimal(10,3) NOT NULL DEFAULT '0.000' COMMENT 'Цена',

              `begin_date` date  COMMENT 'Начало (с даты)',
              `end_date` date  COMMENT 'Конец (по дату)',

              `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT 'create_time',
              `update_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT 'update_time',
              `published` enum('0','1') NOT NULL DEFAULT '0' COMMENT 'published',
              `deleted` enum('0','1') NOT NULL DEFAULT '0' COMMENT 'deleted'
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Цены номеров санатория';
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

        $this->addForeignKey('fv_sanatorium_prices_fv_sanatorium_id_ibfk_1', 'fv_sanatorium_prices', 'sanatorium_id', 'fv_sanatorium_sanatoriums', 'id', 'CASCADE');
        $this->addForeignKey('fv_sanatorium_prices_sanatorium_room_type_id_ibfk_1', 'fv_sanatorium_prices', 'sanatorium_room_type_id', 'fv_sanatorium_room_type', 'id', 'CASCADE');
        $this->addForeignKey('fv_sanatorium_prices_manual_rooms_id_ibfk_1', 'fv_sanatorium_prices', 'manual_room_id', 'fv_manual_rooms', 'id', 'CASCADE');

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
