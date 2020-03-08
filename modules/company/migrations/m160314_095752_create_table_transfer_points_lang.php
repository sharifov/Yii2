<?php

use yii\db\Migration;
use thread\modules\company\CompanyModule;


/**
 * Class m160314_095752_create_table_transfer_points_lang
 *
 * @package thread\modules\company
 */
class m160314_095752_create_table_transfer_points_lang extends Migration
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
            CREATE TABLE `" . $this->tableTransferPointsLang . "` (
                `rid` int(11) unsigned NOT NULL COMMENT 'rid',
                `lang` varchar(5) NOT NULL COMMENT 'lang',
                `title` varchar(255) NOT NULL COMMENT 'title'
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
            ALTER TABLE `" . $this->tableTransferPointsLang . "`
                ADD UNIQUE KEY `rid` (`rid`,`lang`);
        ");

        $this->execute("
            ALTER TABLE `" . $this->tableTransferPointsLang . "`
                ADD CONSTRAINT `" . $this->tableTransferPointsLang . "_ibfk_1` FOREIGN KEY (`rid`) REFERENCES `" . $this->tableTransferPoints . "` (`id`) ON DELETE CASCADE;
        ");

        parent::safeUp();
    }

    /**
     *
     */
    public function safeDown()
    {
        $this->delete($this->tableTransferPointsLang);
        $this->dropTable($this->tableTransferPointsLang);

        parent::safeDown();
    }
}
