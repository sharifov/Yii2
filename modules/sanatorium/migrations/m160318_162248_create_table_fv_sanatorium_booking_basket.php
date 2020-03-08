<?php

use thread\modules\sanatorium\Sanatorium;
use yii\db\Migration;

class m160318_162248_create_table_fv_sanatorium_booking_basket extends Migration
{
    /**
     *
     * @var type
     */
    public $tableSanatorium = 'fv_sanatorium_booking_basket';


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
                `id` int(11) unsigned NOT NULL COMMENT 'rid',
                `sanatorium_booking_id` int(11) unsigned NOT NULL COMMENT 'Забронированный санаторий',
                `sanatorium_room_type_id` int(11) unsigned NOT NULL COMMENT 'Типы номера',

                `price_basic` decimal(10,2) NOT NULL DEFAULT 0 COMMENT '(основная цена)',
                `price_user` decimal(10,2) NOT NULL DEFAULT 0 COMMENT '(валюта клиента)',

                `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT 'create_time',
                `update_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT 'update_time',
                `published` enum('0','1') NOT NULL DEFAULT '0' COMMENT 'published',
                `deleted` enum('0','1') NOT NULL DEFAULT '0' COMMENT 'deleted'
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Список пользователей забронировавших санатории';
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

        $this->addForeignKey(''.$this->tableSanatorium .'_fv_sanatorium_booking_ibfk_1', $this->tableSanatorium , 'sanatorium_booking_id', 'fv_sanatorium_booking', 'id', 'CASCADE');
        $this->addForeignKey(''.$this->tableSanatorium .'fv_sanatorium_room_type', $this->tableSanatorium , 'sanatorium_room_type_id', 'fv_sanatorium_room_type', 'id', 'CASCADE');


        parent::safeUp();
    }

    /**
     *
     */
    public function safeDown()
    {
        $this->delete($this->tableSanatorium);
        $this->dropTable($this->tableSanatorium);

        parent::safeDown();
    }
}
