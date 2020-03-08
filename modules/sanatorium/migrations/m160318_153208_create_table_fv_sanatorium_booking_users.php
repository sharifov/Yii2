<?php

use thread\modules\sanatorium\Sanatorium;
use yii\db\Migration;

class m160318_153208_create_table_fv_sanatorium_booking_users extends Migration
{
    /**
     *
     * @var type
     */
    public $tableSanatorium = 'fv_sanatorium_booking_users';


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
                `name` varchar(255) NOT NULL DEFAULT '' COMMENT 'name',
                `surname` varchar(255) NOT NULL DEFAULT '' COMMENT 'surname',

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
