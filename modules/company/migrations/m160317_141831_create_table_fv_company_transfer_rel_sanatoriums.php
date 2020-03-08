<?php

use yii\db\Migration;
use thread\modules\company\CompanyModule;

class m160317_141831_create_table_fv_company_transfer_rel_sanatoriums extends Migration
{
    /**
     * @var string
     */
    public $tableTransferOrders = 'fv_company_transfer_rel_sanatoriums';

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
                `sanatorium_id` int(11) unsigned NOT NULL COMMENT 'sanatorium_id'
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='rel Трансферы - Санатории';
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
                ADD PRIMARY KEY (`id`)
        ");

        $this->execute("
            ALTER TABLE `" . $this->tableTransferOrders . "`
                MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'id', AUTO_INCREMENT=1;
        ");

        $this->addForeignKey(''.$this->tableTransferOrders.'fv_company_transfer_ibfk_1', $this->tableTransferOrders, 'transfer_id', 'fv_company_transfer', 'id', 'CASCADE');
        $this->addForeignKey(''.$this->tableTransferOrders.'fv_sanatorium_id_ibfk_1', $this->tableTransferOrders, 'sanatorium_id', 'fv_sanatorium_sanatoriums', 'id', 'CASCADE');

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
