<?php

use yii\db\Migration;
use thread\modules\company\CompanyModule;

class m160316_134255_create_table_transfer_orders extends Migration
{
    /**
     * @var string
     */
    public $tableTransferOrders = 'fv_company_transfer_orders';

    /**
     *
     */
    public function init()
    {
        $this->db = CompanyModule::getDb();
        parent::init();
    }

    /**
     *
     */
    public function up()
    {
        $this->execute("
            CREATE TABLE `" . $this->tableTransferOrders . "` (
                `id` int(11) unsigned NOT NULL COMMENT 'id',
                `transfer_id` int(11) unsigned NOT NULL COMMENT 'transfer_id',
                `type` enum('group','personal') NOT NULL DEFAULT 'group' COMMENT 'type',
                `price` DECIMAL(10,2) NOT NULL DEFAULT 0,
                `name_surname` varchar(255) NOT NULL COMMENT 'name_surname',
                `email` varchar(255) NOT NULL COMMENT 'email',
                `phone` varchar(255) NOT NULL COMMENT 'phone',
                `back_transfer` enum('0','1') NOT NULL DEFAULT '0' COMMENT 'back_transfer',
                `flight_number_p1` varchar(255) NOT NULL COMMENT 'flight_number_p1',
                `flight_number_p2` varchar(255) NOT NULL COMMENT 'flight_number_p2',
                `arrival_date_p1` varchar(255) NOT NULL COMMENT 'arrival_date_p1',
                `arrival_date_p2` varchar(255) NOT NULL COMMENT 'arrival_date_p2',
                `arrival_time_p1` varchar(255) NOT NULL COMMENT 'arrival_time_p1',
                `arrival_time_p2` varchar(255) NOT NULL COMMENT 'arrival_time_p2',
                `number_persons` int(11) unsigned NOT NULL COMMENT 'number_persons',
                `address` varchar(255) NOT NULL COMMENT 'address',
                `comment` varchar(512) NOT NULL COMMENT 'comment',
                `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT 'create_time',
                `update_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT 'update_time',
                `published` enum('0','1') NOT NULL DEFAULT '0' COMMENT 'published',
                `deleted` enum('0','1') NOT NULL DEFAULT '0' COMMENT 'deleted'
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='трансферы';
        ");

        parent::up();
    }

    /**
     *
     */
    public function safeUp()
    {
        $this->execute("
            ALTER TABLE `" . $this->tableTransferOrders . "`
               ADD PRIMARY KEY (`id`),
               ADD KEY `deleted` (`deleted`),
               ADD KEY `published` (`published`),
               ADD KEY `transfer_id_ibfk_1` (`transfer_id`)
        ");

        $this->execute("
            ALTER TABLE `" . $this->tableTransferOrders . "`
                MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'id', AUTO_INCREMENT=1;
        ");

        $this->execute("
            ALTER TABLE `" . $this->tableTransferOrders . "`
              ADD CONSTRAINT `transfer_id_ibfk_1` FOREIGN KEY (`transfer_id`) REFERENCES `fv_company_transfer` (`id`) ON DELETE CASCADE
        ");

        parent::safeUp();
    }

    /**
     *
     */
    public function safeDown()
    {
        $this->delete($this->tableTransferOrders);
        $this->dropTable($this->tableTransferOrders);

        parent::safeDown();
    }
}
