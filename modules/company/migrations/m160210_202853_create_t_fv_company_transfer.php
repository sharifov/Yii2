<?php

use yii\db\Migration;
use thread\modules\company\CompanyModule;

class m160210_202853_create_t_fv_company_transfer extends Migration
{
    /**
     *
     * @var type
     */
    public $tableCompany = 'fv_company_transfer';

    /**
     *
     * @var type
     */
    public $tableCompanyLang = 'fv_company_transfer_lang';

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
           CREATE TABLE `". $this->tableCompany ."` (
              `id` int(11) unsigned NOT NULL COMMENT 'id',
              `alias` varchar(255) NOT NULL COMMENT 'alias',
              `location_country_id` int(11) unsigned NOT NULL COMMENT 'страна',
              `sanatoriums_id` int(11) unsigned NOT NULL COMMENT 'санаторий',
              `price` int(11) NOT NULL DEFAULT '0',
              `type_transfer` enum('групповой','персональный') NOT NULL DEFAULT 'групповой' COMMENT 'Тип трансфера',
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
            ALTER TABLE `" . $this->tableCompany . "`
               ADD PRIMARY KEY (`id`),
               ADD KEY `deleted` (`deleted`),
               ADD KEY `published` (`published`),
               ADD KEY `location_country_id_ibfk_1` (`location_country_id`),
               ADD KEY `sanatoriums_id_ibfk_1` (`sanatoriums_id`)
        ");

        $this->execute("
            ALTER TABLE `" . $this->tableCompany . "`
                MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'id', AUTO_INCREMENT=1;
        ");

        $this->execute("
            ALTER TABLE `" . $this->tableCompany . "`
              ADD CONSTRAINT `location_country_id_ibfk_1` FOREIGN KEY (`location_country_id`) REFERENCES `fv_location_country` (`id`),
              ADD CONSTRAINT `sanatoriums_id_ibfk_1` FOREIGN KEY (`sanatoriums_id`) REFERENCES `fv_sanatorium_sanatoriums` (`id`)
        ");

        parent::safeUp();
    }

    /**
     *
     */
    public function safeDown()
    {
        $this->delete($this->tableCompanyLang);
        $this->dropTable($this->tableCompanyLang);

        parent::safeDown();
    }
}
