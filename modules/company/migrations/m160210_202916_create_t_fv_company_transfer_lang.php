<?php

use yii\db\Migration;
use thread\modules\company\CompanyModule;

class m160210_202916_create_t_fv_company_transfer_lang extends Migration
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
            CREATE TABLE `". $this->tableCompanyLang ."` (
              `rid` int(11) unsigned NOT NULL COMMENT 'rid',
              `lang` varchar(5) NOT NULL COMMENT 'lang',
              `title` varchar(255) NOT NULL COMMENT 'lang',
              `desc_short` varchar(255) DEFAULT NULL COMMENT 'short description',
              `start_transfer` varchar(255) NOT NULL COMMENT 'город точки начала трансфера',
              `end_transfer` varchar(255) NOT NULL COMMENT 'город точки окончания трансфера'
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='location city lang';
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
