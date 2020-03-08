<?php

use thread\modules\sanatorium\Sanatorium;
use yii\db\Migration;

class m160322_111908_create_tanle_fv_sanatorium_total_comments extends Migration
{
    /**
     *
     * @var type
     */
    public $tableSanatorium = 'fv_sanatorium_total_comments';


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

                `total_quality` float  NOT NULL DEFAULT 0 COMMENT 'общее качество',
                `total_quality_accommodation` float NOT NULL DEFAULT 0 COMMENT 'общее качество размещения',
                `total_quality_food` float NOT NULL DEFAULT 0 COMMENT 'общее качество питания',
                `total_quality_staff` float NOT NULL DEFAULT 0 COMMENT 'общее качество персонала',
                `total_location` float  NOT NULL DEFAULT 0 COMMENT 'общее расположение',

                `total_comments` float  NOT NULL DEFAULT 0 COMMENT 'всего комментариев',
                `average_rating` float  NOT NULL DEFAULT 0 COMMENT 'средняя оценка',

                `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT 'create_time',
                `update_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT 'update_time',
                `published` enum('0','1') NOT NULL DEFAULT '0' COMMENT 'published',
                `deleted` enum('0','1') NOT NULL DEFAULT '0' COMMENT 'deleted'
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Общии отзывы по санаторию';
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
