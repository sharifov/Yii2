<?php

use yii\db\Migration;
use thread\modules\location\Location;

/**
 * Class m160127_132919_create_fv_location_rel_country_language_table
 *
 * @package thread\modules\location
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c) 2015, Thread
 */
class m160127_132919_create_fv_location_rel_country_language_table extends Migration {

    /**
     *
     * @var type
     */
    public $tableLocationCountry = 'fv_location_country';

    /**
     *
     * @var type
     */
    public $tableLocationLanguage = 'fv_location_language';

    /**
     *
     * @var type
     */
    public $tableLocationRelCountryLanguage = 'fv_location_rel_country_language';

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
            CREATE TABLE `" . $this->tableLocationRelCountryLanguage . "` (
                `language_id` int(11) UNSIGNED NOT NULL COMMENT 'language',
                `country_id` int(11) UNSIGNED NOT NULL COMMENT 'country'
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='location relations country language';
        ");

        parent::up();
    }

    /**
     *
     */
    public function safeUp() {

        $this->execute("
            ALTER TABLE `" . $this->tableLocationRelCountryLanguage . "`
                ADD UNIQUE KEY `language_id_2` (`language_id`,`country_id`),
                ADD KEY `country_id` (`country_id`),
                ADD KEY `language_id` (`language_id`);
        ");

        $this->execute("
            ALTER TABLE `" . $this->tableLocationRelCountryLanguage . "`
                ADD CONSTRAINT `" . $this->tableLocationRelCountryLanguage . "_ibfk_1` FOREIGN KEY (`language_id`) REFERENCES `" . $this->tableLocationLanguage . "` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
                ADD CONSTRAINT `" . $this->tableLocationRelCountryLanguage . "_ibfk_2` FOREIGN KEY (`country_id`) REFERENCES `" . $this->tableLocationCountry . "` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
        ");

        parent::safeUp();
    }

    /**
     *
     */
    public function safeDown() {
        $this->delete($this->tableMenu);
        $this->dropTable($this->tableMenu);

        parent::safeDown();
    }

}
