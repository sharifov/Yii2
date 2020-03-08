<?php

use yii\db\Migration;
use thread\modules\location\Location;

/**
 * Class m160127_132743_create_fv_location_language_table
 *
 * @package thread\modules\location
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c) 2015, Thread
 */
class m160127_132743_create_fv_location_language_table extends Migration {

    /**
     *
     * @var type
     */
    public $tableLocationLanguage = 'fv_location_language';

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
            CREATE TABLE `" . $this->tableLocationLanguage . "` (
                `id` int(11) UNSIGNED NOT NULL COMMENT 'id',
                `alias` varchar(50) NOT NULL COMMENT 'alias',
                `title` varchar(50) NOT NULL COMMENT 'title',
                `create_time` int(11) UNSIGNED NOT NULL DEFAULT '0' COMMENT 'create_time',
                `update_time` int(11) UNSIGNED NOT NULL DEFAULT '0' COMMENT 'update_time',
                `published` enum('0','1') NOT NULL DEFAULT '0' COMMENT 'published',
                `deleted` enum('0','1') NOT NULL DEFAULT '0' COMMENT 'deleted'
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='location language';
        ");

        parent::up();
    }

    /**
     *
     */
    public function safeUp() {

        $this->execute("
            ALTER TABLE `" . $this->tableLocationLanguage . "`
                ADD PRIMARY KEY (`id`),
                ADD UNIQUE KEY `alias` (`alias`),
                ADD KEY `deleted` (`deleted`),
                ADD KEY `published` (`published`);
        ");
        
        $this->execute("
            ALTER TABLE `" . $this->tableLocationLanguage . "`
                MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'id', AUTO_INCREMENT=1;
        ");

        parent::safeUp();
    }

    /**
     *
     */
    public function safeDown() {
        $this->delete($this->tableLocationLanguage);
        $this->dropTable($this->tableLocationLanguage);

        parent::safeDown();
    }

}
