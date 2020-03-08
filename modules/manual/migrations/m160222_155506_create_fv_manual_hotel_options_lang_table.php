<?php

use yii\db\Migration;
use thread\modules\manual\Manual;

/**
 * Class m160222_155506_create_fv_manual_hotel_options_lang_table
 *
 * @package thread\modules\manual
 */
class m160222_155506_create_fv_manual_hotel_options_lang_table extends Migration
{

    /**
     *
     * @var type
     */
    public $tableManualHotelOtions = 'fv_manual_hotel_options';

    /**
     *
     * @var type
     */
    public $tableManualHotelOtionsLang = 'fv_manual_hotel_options_lang';

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
            CREATE TABLE `" . $this->tableManualHotelOtionsLang . "` (
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
            ALTER TABLE `" . $this->tableManualHotelOtionsLang . "`
                ADD UNIQUE KEY `rid` (`rid`,`lang`);
        ");

        $this->execute("
            ALTER TABLE `" . $this->tableManualHotelOtionsLang . "`
                ADD CONSTRAINT `" . $this->tableManualHotelOtionsLang . "_ibfk_1` FOREIGN KEY (`rid`) REFERENCES `" . $this->tableManualHotelOtions . "` (`id`) ON DELETE CASCADE;
        ");

        parent::safeUp();
    }

    /**
     *
     */
    public function safeDown()
    {
        $this->delete($this->tableManualHotelOtionsLang);
        $this->dropTable($this->tableManualHotelOtionsLang);

        parent::safeDown();
    }
}
