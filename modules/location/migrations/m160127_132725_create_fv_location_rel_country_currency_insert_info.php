<?php

use yii\db\Migration;
use thread\modules\location\Location;

/**
 * Class m160127_132725_create_fv_location_rel_country_currency_insert_info
 *
 * @package thread\modules\location
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c) 2015, Thread
 */
class m160127_132725_create_fv_location_rel_country_currency_insert_info extends Migration {

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
    public function safeUp() {

        parent::safeUp();
    }

    /**
     *
     */
    public function safeDown() {
        $this->delete($this->tableLocationRelCountryCurrency);

        parent::safeDown();
    }

}
