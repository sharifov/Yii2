<?php

use yii\db\Migration;
use thread\modules\location\Location;

/**
 * Class m160127_132514_create_fv_location_country_table
 *
 * @package thread\modules\location
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c) 2015, Thread
 */
class m160127_132514_create_fv_location_country_table extends Migration {

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
            CREATE TABLE `".$this->tableLocationCountry."` (
                `id` int(11) UNSIGNED NOT NULL COMMENT 'id',
                `alias` varchar(128) NOT NULL COMMENT 'alias',
                `title` varchar(128) NOT NULL DEFAULT '' COMMENT 'title',
                `alpha2` char(2) NOT NULL DEFAULT '' COMMENT 'alpha2',
                `alpha3` char(3) NOT NULL DEFAULT '' COMMENT 'alpha3',
                `iso` int(11) NOT NULL DEFAULT '0' COMMENT 'iso',
                `create_time` int(11) UNSIGNED NOT NULL DEFAULT '0' COMMENT 'create_time',
                `update_time` int(11) UNSIGNED NOT NULL DEFAULT '0' COMMENT 'update_time',
                `published` enum('0','1') NOT NULL DEFAULT '0' COMMENT 'published',
                `deleted` enum('0','1') NOT NULL DEFAULT '0' COMMENT 'deleted'
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='location country';
        ");

        parent::up();
    }

    /**
     *
     */
    public function safeUp() {

        $this->execute("
            ALTER TABLE `".$this->tableLocationCountry."`
                ADD PRIMARY KEY (`id`),
                ADD KEY `name` (`title`),
                ADD KEY `alpha2` (`alpha2`),
                ADD KEY `alpha3` (`alpha3`),
                ADD KEY `iso` (`iso`),
                ADD KEY `published` (`published`,`deleted`);
        ");

        $this->execute("
            ALTER TABLE `".$this->tableLocationCountry."`
                MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'id', AUTO_INCREMENT=1;
        ");

        parent::safeUp();
    }

    /**
     *
     */
    public function safeDown() {
        $this->delete($this->tableLocationCountry);
        $this->dropTable($this->tableLocationCountry);

        parent::safeDown();
    }

}
