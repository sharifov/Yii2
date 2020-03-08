<?php

use thread\modules\urlcache\Urlcache;
use yii\db\Migration;

class m160610_145407_init_table_urlcache extends Migration
{
    /**
     *
     * @var type
     */
    public $tableMenu = 'fv_urlcache';


    /**
     *
     */
    public function init() {

        $this->db = Urlcache::getDb();
        parent::init();
    }

    /**
     *
     */
    public function up() {
        $this->execute("
            CREATE TABLE `" . $this->tableMenu . "` (
                `id` int(11) UNSIGNED NOT NULL COMMENT 'id',
                `hash` varchar(255) NOT NULL COMMENT 'текущий url',
                `cleaning` int(11)NOT NULL COMMENT 'Время очистки кеша',
                `create_time` int(11) UNSIGNED NOT NULL DEFAULT '0' COMMENT 'create_time',
                `update_time` int(11) UNSIGNED NOT NULL DEFAULT '0' COMMENT 'update_time',
                `published` enum('0','1') NOT NULL DEFAULT '0' COMMENT 'published',
                `deleted` enum('0','1') NOT NULL DEFAULT '0' COMMENT 'deleted'
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='url cache';
        ");

        parent::up();
    }

    /**
     *
     */
    public function safeUp() {

        $this->execute("
            ALTER TABLE `" . $this->tableMenu . "`
                ADD PRIMARY KEY (`id`),
                ADD KEY `deleted` (`deleted`),
                ADD KEY `published` (`published`),
                ADD KEY `cleaning` (`cleaning`);
        ");

        $this->execute("
            ALTER TABLE `" . $this->tableMenu . "`
                MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'id', AUTO_INCREMENT=1;
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
