<?php

use thread\modules\sanatorium\Sanatorium;
use yii\db\Migration;

class m160318_134415_create_table_fv_sanatorium_booking extends Migration
{
    /**
     *
     * @var type
     */
    public $tableSanatorium = 'fv_sanatorium_booking';


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
              `token` varchar(255) NOT NULL DEFAULT '' COMMENT 'токен',
              `email` varchar(255) NOT NULL DEFAULT '' COMMENT 'email',
              `phone` varchar(100) NOT NULL DEFAULT '' COMMENT 'номер телефона',
              `total_price_basic` decimal(10,2) NOT NULL DEFAULT 0 COMMENT 'общая стоймость (основная цена)',
              `total_price_user` decimal(10,2) NOT NULL DEFAULT 0 COMMENT 'общая стоймость (валюта клиента)',

              `date_begin` datetime NOT NULL DEFAULT 0 COMMENT 'дата прибытия клиента',
              `date_end` datetime NOT NULL DEFAULT 0 COMMENT 'дата выезда выезда',

              `number_rooms` int(11)  NOT NULL DEFAULT 0 COMMENT 'количество заказаных номеров',
              `number_guests` int(11)  NOT NULL DEFAULT 0 COMMENT 'количество гостей',
              `number_days` int(11)  NOT NULL DEFAULT 0 COMMENT 'количество дней проживания',

              `card_number` varchar(100)  NOT NULL DEFAULT 0 COMMENT 'номер карты клинта',
              `card_type` varchar(100)  NOT NULL DEFAULT 0 COMMENT 'тип банковской карты',
              `card_email` varchar(255)  NOT NULL DEFAULT '' COMMENT 'email',
              `card_year` int(11)  NOT NULL DEFAULT 0 COMMENT 'срок действия до (года)',
              `card_month` int(11)  NOT NULL DEFAULT 0 COMMENT 'срок действия до (месяца)',


              `comment_type_bed` int(11)  NOT NULL DEFAULT 0 COMMENT 'важнрсит пожелания 1) Не важно 2) Две односпальные 3) Одна двухспальная',
              `comment` varchar(255) NOT NULL DEFAULT '' COMMENT 'пожелание (комментарий)',
              `comment_baby_bed` int(11) NOT NULL DEFAULT 0 COMMENT 'детская кровать?',

              `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT 'create_time',
              `update_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT 'update_time',
              `published` enum('0','1') NOT NULL DEFAULT '0' COMMENT 'published',
              `deleted` enum('0','1') NOT NULL DEFAULT '0' COMMENT 'deleted'
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Бронирование санатория';
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
                       ADD KEY `published` (`published`),
                       ADD UNIQUE `token` (`token`)
        ");

        $this->execute("
            ALTER TABLE `" . $this->tableSanatorium . "`
                MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'id', AUTO_INCREMENT=1;
        ");

        $this->addForeignKey(''.$this->tableSanatorium .'_fv_sanatorium_id_ibfk_1', $this->tableSanatorium , 'sanatorium_id', 'fv_sanatorium_sanatoriums', 'id', 'CASCADE');

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
