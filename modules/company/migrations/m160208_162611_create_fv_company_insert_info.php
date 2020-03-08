<?php

use yii\db\Migration;
use thread\modules\company\CompanyModule;

/**
 * Class m160208_162611_create_fv_company_insert_info
 *
 * @package thread\modules\company
 */
class m160208_162611_create_fv_company_insert_info extends Migration
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
    public function safeUp()
    {
        $this->execute("
            INSERT INTO `" . $this->tableCompany . "` (`id`, `country_id`, `city_id`, `alias`, `image_link`, `phone`, `email`, `create_time`, `update_time`, `published`, `deleted`) VALUES
                (9, 9908, 0, '', NULL, 'sd', 'test@test.com', 1454586757, 1454927458, '1', '0');
        ");

        $this->execute("
            INSERT INTO `" . $this->tableCompanyLang . "` (`rid`, `lang`, `title`, `content`, `contact_person`, `address`, `postcode`, `tax_number`, `vat_number`, `representative`) VALUES
                (9, 'ru-RU', 'test', '', 'ds', 'sd', 'sd', 'sd', 'sd', 'sd')
        ");

        parent::safeUp();
    }

    /**
     *
     */
    public function safeDown()
    {
        $this->delete($this->tableCompany);

        parent::safeDown();
    }
}
