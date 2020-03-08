<?php

use yii\db\Migration;
use thread\modules\manual\Manual;

/**
 * Class m160222_155436_create_fv_manual_hotel_options_table
 *
 * @package thread\modules\manual
 */
class m160222_155436_create_fv_manual_hotel_options_table extends Migration
{
    /**
     *
     * @var type
     */
    public $tableManualHotelOtions = 'fv_manual_hotel_options';

    /**
     *
     */
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
            CREATE TABLE `" . $this->tableManualHotelOtions . "` (
                `id` int(11) unsigned NOT NULL COMMENT 'id',
                `group_id` int(11) NOT NULL DEFAULT '0',
                `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT 'create_time',
                `update_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT 'update_time',
                `published` enum('0','1') NOT NULL DEFAULT '0' COMMENT 'published',
                `deleted` enum('0','1') NOT NULL DEFAULT '0' COMMENT 'deleted'
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
        ");

        parent::up();
    }

    /**
     *
     */
    public function safeUp()
    {

        $this->execute("
            ALTER TABLE `" . $this->tableManualHotelOtions . "`
                ADD PRIMARY KEY (`id`),
                ADD KEY `deleted` (`deleted`),
                ADD KEY `published` (`published`);
        ");

        $this->execute("
            ALTER TABLE `" . $this->tableManualHotelOtions . "`
                MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'id', AUTO_INCREMENT=1;
        ");

        parent::safeUp();
    }

    /**
     *
     */
    public function safeDown()
    {
        $this->delete($this->tableManualHotelOtions);
        $this->dropTable($this->tableManualHotelOtions);

        parent::safeDown();
    }
}
