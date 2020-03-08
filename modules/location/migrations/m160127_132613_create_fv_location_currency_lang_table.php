<?php

use yii\db\Migration;
use thread\modules\location\Location;

/**
 * Class m160127_132613_create_fv_location_currency_lang_table
 *
 * @package thread\modules\location
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c) 2015, Thread
 */
class m160127_132613_create_fv_location_currency_lang_table extends Migration {

    /**
     *
     * @var type
     */
    public $tableLocationCurrency = 'fv_location_currency';

    /**
     *
     * @var type
     */
    public $tableLocationCurrencyLang = 'fv_location_currency_lang';

    /**
     *
     */
    public function init() {

        $this->db = Location::getDb();
        parent::init();
    }

    /**
     *
     */
    public function up() {
        $this->execute("
            CREATE TABLE `" . $this->tableLocationCurrencyLang . "` (
                `rid` int(11) UNSIGNED NOT NULL COMMENT 'id',
                `lang` varchar(5) NOT NULL COMMENT 'lang',
                `title` varchar(255) NOT NULL DEFAULT '' COMMENT 'title'
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='location currency lang';
        ");

        parent::up();
    }

    /**
     *
     */
    public function safeUp() {

        $this->execute("
            ALTER TABLE `" . $this->tableLocationCurrencyLang . "`
                ADD UNIQUE KEY `rid` (`rid`,`lang`);
        ");

        $this->execute("
            ALTER TABLE `" . $this->tableLocationCurrencyLang . "`
                ADD CONSTRAINT `" . $this->tableLocationCurrencyLang . "_ibfk_1` FOREIGN KEY (`rid`) REFERENCES `" . $this->tableLocationCurrency . "` (`id`) ON DELETE CASCADE;
        ");

        parent::safeUp();
    }

    /**
     *
     */
    public function safeDown() {
        $this->delete($this->tableLocationCurrencyLang);
        $this->dropTable($this->tableLocationCurrencyLang);

        parent::safeDown();
    }

}
