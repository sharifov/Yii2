<?php

use yii\db\Migration;
use thread\modules\location\Location;

/**
 * Class m160127_132715_create_fv_location_currency_insert_info
 *
 * @package thread\modules\location
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c) 2015, Thread
 */

class m160127_132715_create_fv_location_currency_insert_info extends Migration
{
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
    public function safeUp() {

        $this->execute("
            INSERT INTO `".$this->tableLocationCurrency."` (`id`, `alias`, `code1`, `code2`, `title`, `create_time`, `update_time`, `published`, `deleted`) VALUES
                (1, 'rossiyskiy-rublj', '810', 'RUR', 'Российский рубль', 0, 1424035436, '1', '0'),
                (2, 'dollar-ssha', '840', 'USD', 'Доллар США', 0, 1424035592, '1', '0'),
                (3, 'evro', '978', 'EUR', 'Евро', 0, 1424035667, '1', '0'),
                (4, 'grivna', '980', 'UAH', 'Гривна', 0, 1424035584, '1', '0');
        ");

        $this->execute("
            INSERT INTO `".$this->tableLocationCurrencyLang."` (`rid`, `lang`, `title`) VALUES
                (1, 'ru-RU', 'Российский рубль'),
                (2, 'ru-RU', 'Доллар США'),
                (3, 'ru-RU', 'Евро'),
                (4, 'ru-RU', 'Гривна');
        ");

        parent::safeUp();
    }

    /**
     *
     */
    public function safeDown() {
        $this->delete($this->tableLocationCurrency);

        parent::safeDown();
    }
}
