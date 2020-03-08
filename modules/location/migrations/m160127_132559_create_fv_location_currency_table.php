<?php

use yii\db\Migration;
use thread\modules\location\Location;

/**
 * Class m160127_132559_create_fv_location_currency_table
 *
 * @package thread\modules\location
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c) 2015, Thread
 */
class m160127_132559_create_fv_location_currency_table extends Migration {

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
        CREATE TABLE `" . $this->tableLocationCurrency . "` (
            `id` int(11) UNSIGNED NOT NULL COMMENT 'id',
            `alias` varchar(255) NOT NULL COMMENT 'alias',
            `code1` varchar(4) NOT NULL DEFAULT '' COMMENT 'code1',
            `code2` varchar(4) NOT NULL DEFAULT '' COMMENT 'code2',
            `title` varchar(255) NOT NULL DEFAULT '' COMMENT 'title',
            `create_time` int(11) UNSIGNED NOT NULL DEFAULT '0' COMMENT 'create_time',
            `update_time` int(11) UNSIGNED NOT NULL DEFAULT '0' COMMENT 'update_time',
            `published` enum('0','1') NOT NULL DEFAULT '0' COMMENT 'published',
            `deleted` enum('0','1') NOT NULL DEFAULT '0' COMMENT 'deleted'
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='location currency';
        ");

        parent::up();
    }

    /**
     *
     */
    public function safeUp() {

        $this->execute("
            ALTER TABLE `" . $this->tableLocationCurrency . "`
                ADD PRIMARY KEY (`id`),
                ADD KEY `published` (`published`,`deleted`);
        ");

        $this->execute("
            ALTER TABLE `" . $this->tableLocationCurrency . "`
                MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'id', AUTO_INCREMENT=1;
        ");

        parent::safeUp();
    }

    /**
     *
     */
    public function safeDown() {
        $this->delete($this->tableLocationCurrency);
        $this->dropTable($this->tableLocationCurrency);

        parent::safeDown();
    }

}
