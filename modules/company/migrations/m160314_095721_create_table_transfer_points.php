<?php

    use yii\db\Migration;
    use thread\modules\company\CompanyModule;

/**
 * Class m160314_095721_create_table_transfer_points
 *
 * @package thread\modules\company
 */
class m160314_095721_create_table_transfer_points extends Migration
{
    /**
     *
     * @var type
     */
    public $tableTransferPoints = 'fv_company_transfer_points';

    /**
     *
     * @var type
     */
    public $tableTransferPointsLang = 'fv_company_transfer_points_lang';

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
           CREATE TABLE `". $this->tableTransferPoints ."` (
              `id` int(11) unsigned NOT NULL COMMENT 'id',
              `country_id` int(11) unsigned NOT NULL COMMENT 'страна',
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
            ALTER TABLE `" . $this->tableTransferPoints . "`
               ADD PRIMARY KEY (`id`),
               ADD KEY `deleted` (`deleted`),
               ADD KEY `published` (`published`),
               ADD KEY `country_id_ibfk_1` (`country_id`)
        ");

        $this->execute("
            ALTER TABLE `" . $this->tableTransferPoints . "`
                MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'id', AUTO_INCREMENT=1;
        ");

        $this->execute("
            ALTER TABLE `" . $this->tableTransferPoints . "`
              ADD CONSTRAINT `country_id_ibfk_1` FOREIGN KEY (`country_id`) REFERENCES `fv_location_country` (`id`)
        ");

        parent::safeUp();
    }

    /**
     *
     */
    public function safeDown()
    {
        $this->delete($this->tableTransferPoints);
        $this->dropTable($this->tableTransferPoints);

        parent::safeDown();
    }

}
