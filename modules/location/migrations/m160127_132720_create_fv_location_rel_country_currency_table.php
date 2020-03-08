<?php

use yii\db\Migration;
use thread\modules\location\Location;

/**
 * Class m160127_132720_create_fv_location_rel_country_currency_table
 *
 * @package thread\modules\location
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c) 2015, Thread
 */
class m160127_132720_create_fv_location_rel_country_currency_table extends Migration {

    /**
     *
     * @var type
     */
    public $tableLocationCountry = 'fv_location_country';

    /**
     *
     * @var type
     */
    public $tableLocationCurrency = 'fv_location_currency';

    /**
     *
     * @var type
     */
    public $tableLocationRelCountryCurrency = 'fv_location_rel_country_currency';

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
            CREATE TABLE `" . $this->tableLocationRelCountryCurrency . "` (
                `currency_id` int(11) UNSIGNED NOT NULL DEFAULT '0' COMMENT 'currency',
                `country_id` int(11) UNSIGNED NOT NULL COMMENT 'country'
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='location relations country currency';
        ");

        parent::up();
    }

    /**
     *
     */
    public function safeUp() {

        $this->execute("
            ALTER TABLE `" . $this->tableLocationRelCountryCurrency . "`
                ADD UNIQUE KEY `currency_id_2` (`currency_id`,`country_id`),
                ADD KEY `country_id` (`country_id`),
                ADD KEY `currency_id` (`currency_id`);
        ");

        $this->execute("
            ALTER TABLE `" . $this->tableLocationRelCountryCurrency . "`
                ADD CONSTRAINT `" . $this->tableLocationRelCountryCurrency . "_ibfk_1` FOREIGN KEY (`currency_id`) REFERENCES `" . $this->tableLocationCurrency . "` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
                ADD CONSTRAINT `" . $this->tableLocationRelCountryCurrency . "_ibfk_2` FOREIGN KEY (`country_id`) REFERENCES `" . $this->tableLocationCountry . "` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
        ");

        parent::safeUp();
    }

    /**
     *
     */
    public function safeDown() {
        $this->delete($this->tableLocationRelCountryCurrency);
        $this->dropTable($this->tableLocationRelCountryCurrency);

        parent::safeDown();
    }

}
