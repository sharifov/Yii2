<?php

use thread\modules\sanatorium\Sanatorium;
use yii\db\Migration;

class m160322_101547_create_tanle_fv_sanatorium_comments extends Migration
{
    /**
     *
     * @var type
     */
    public $tableSanatorium = 'fv_sanatorium_comments';


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

                `sanatorium_id` int(11) unsigned NOT NULL COMMENT 'Санаторий',
                `user_id` int(11) unsigned NOT NULL COMMENT 'user_id',

                `quality` float  NOT NULL DEFAULT 0 COMMENT 'качество',
                `quality_accommodation` float NOT NULL DEFAULT 0 COMMENT 'Качество размещения',
                `quality_food` float NOT NULL DEFAULT 0 COMMENT 'качество питания',
                `quality_staff` float NOT NULL DEFAULT 0 COMMENT 'качество персонала',
                `location` float  NOT NULL DEFAULT 0 COMMENT 'расположение',

                `positive_review` varchar(512)  DEFAULT '' COMMENT 'положительный отзыв',
                `negative_review` varchar(512)  DEFAULT '' COMMENT 'отрицательный отзыв',

                `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT 'create_time',
                `update_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT 'update_time',
                `published` enum('0','1') NOT NULL DEFAULT '0' COMMENT 'published',
                `deleted` enum('0','1') NOT NULL DEFAULT '0' COMMENT 'deleted'
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Отзывы санатория';
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

        $this->addForeignKey(''.$this->tableSanatorium .'_fv_sanatorium_booking_ibfk_1', $this->tableSanatorium , 'sanatorium_id', 'fv_sanatorium_sanatoriums', 'id', 'CASCADE');


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
