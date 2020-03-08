<?php

use yii\db\Migration;
use thread\modules\location\Location;

/**
 * Class m160127_132526_create_fv_location_country_lang_table
 *
 * @package thread\modules\location
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c) 2015, Thread
 */
class m160127_132526_create_fv_location_country_lang_table extends Migration {

    /**
     *
     * @var type
     */
    public $tableLocationCountry = 'fv_location_country';

    /**
     *
     * @var type
     */
    public $tableLocationCountryLang = 'fv_location_country_lang';

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
            CREATE TABLE `" . $this->tableLocationCountryLang . "` (
                `rid` int(11) UNSIGNED NOT NULL COMMENT 'rid',
                `lang` varchar(5) NOT NULL COMMENT 'lang',
                `title` varchar(128) NOT NULL DEFAULT '' COMMENT 'title'
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='location country lang';
        ");

        parent::up();
    }

    /**
     *
     */
    public function safeUp() {

        $this->execute("
            ALTER TABLE `" . $this->tableLocationCountryLang . "`
                ADD UNIQUE KEY `rid` (`rid`,`lang`);
        ");

        $this->execute("
            ALTER TABLE `" . $this->tableLocationCountryLang . "`
                ADD CONSTRAINT `" . $this->tableLocationCountryLang . "_ibfk_1` FOREIGN KEY (`rid`) REFERENCES `" . $this->tableLocationCountry . "` (`id`) ON DELETE CASCADE;
        ");

        parent::safeUp();
    }

    /**
     *
     */
    public function safeDown() {
        $this->delete($this->tableLocationCountryLang);
        $this->dropTable($this->tableLocationCountryLang);

        parent::safeDown();
    }

}
