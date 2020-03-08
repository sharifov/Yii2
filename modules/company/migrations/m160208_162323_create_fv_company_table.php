<?php

use yii\db\Migration;
use thread\modules\company\CompanyModule;

/**
 * Class m160208_162323_create_fv_company_table
 *
 * @package thread\modules\company
 */
class m160208_162323_create_fv_company_table extends Migration
{
    /**
     *
     * @var type
     */
    public $tableCompany = 'fv_company';

    /**
     *
     * @var type
     */
    public $tableCompanyLang = 'fv_company_lang';

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
            CREATE TABLE `" . $this->tableCompany . "` (
                `id` int(11) unsigned NOT NULL COMMENT 'id',
                `country_id` int(11) NOT NULL DEFAULT '0',
                `city_id` int(11) NOT NULL DEFAULT '0',
                `alias` varchar(255) NOT NULL COMMENT 'alias',
                `image_link` varchar(255) DEFAULT NULL COMMENT 'image_link',
                `phone` varchar(255) NOT NULL DEFAULT '',
                `email` varchar(255) NOT NULL,
                `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT 'create_time',
                `update_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT 'update_time',
                `published` enum('0','1') NOT NULL DEFAULT '0' COMMENT 'published',
                `deleted` enum('0','1') NOT NULL DEFAULT '0' COMMENT 'deleted'
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='company';
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
                ADD KEY `published` (`published`);
        ");

        $this->execute("
            ALTER TABLE `" . $this->tableCompany . "`
                MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'id', AUTO_INCREMENT=1;
        ");

        parent::safeUp();
    }

    /**
     *
     */
    public function safeDown()
    {
        $this->delete($this->tableCompany);
        $this->dropTable($this->tableCompany);

        parent::safeDown();
    }
}
