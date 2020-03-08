<?php

use yii\db\Migration;
use thread\modules\company\CompanyModule;

/**
 * Class m160208_162549_create_fv_company_lang_table
 *
 * @package thread\modules\company
 */
class m160208_162549_create_fv_company_lang_table extends Migration
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
            CREATE TABLE `" . $this->tableCompanyLang . "` (
                `rid` int(11) unsigned NOT NULL COMMENT 'rid',
                `lang` varchar(5) NOT NULL COMMENT 'lang',
                `title` varchar(255) NOT NULL COMMENT 'title',
                `content` text NOT NULL COMMENT 'content',
                `contact_person` varchar(255) NOT NULL DEFAULT '',
                `address` varchar(255) NOT NULL DEFAULT '',
                `postcode` varchar(255) NOT NULL DEFAULT '',
                `tax_number` varchar(255) NOT NULL DEFAULT '',
                `vat_number` varchar(255) NOT NULL DEFAULT '',
                `representative` varchar(255) NOT NULL DEFAULT ''
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='company lang';
        ");

        parent::up();
    }

    /**
     *
     */
    public function safeUp()
    {
        $this->execute("
            ALTER TABLE `" . $this->tableCompanyLang . "`
                ADD UNIQUE KEY `rid` (`rid`,`lang`);
        ");

        $this->execute("
            ALTER TABLE `" . $this->tableCompanyLang . "`
                ADD CONSTRAINT `" . $this->tableCompanyLang . "_ibfk_1` FOREIGN KEY (`rid`) REFERENCES `" . $this->tableCompany . "` (`id`) ON DELETE CASCADE;
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
