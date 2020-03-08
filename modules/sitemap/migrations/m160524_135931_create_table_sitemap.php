<?php

use yii\db\Migration;

/**
 * Handles the creation for table `table_sitemap`.
 */
class m160524_135931_create_table_sitemap extends Migration
{

    private  $tableMenu = 'fv_seo_sitemap_element';


    /**
     *
     */
    public function init() {

        $this->db = \thread\modules\sitemap\Sitemap::getDb();
        parent::init();
    }


    /**
     * @inheritdoc
     */
    public function up()
    {

        $this->execute("
           CREATE TABLE `". $this->tableMenu ."` (
              `id` int(11) NOT NULL  COMMENT 'id',
              `module_id` varchar(255) NOT NULL,
              `model_id` varchar(255) NOT NULL,
              `key` varchar(50) NOT NULL,
              `url` varchar(2048) NOT NULL,
              `create_time` int(11) NOT NULL DEFAULT '0' COMMENT 'create_time',
              `update_time` int(11) NOT NULL DEFAULT '0' COMMENT 'update_time',
              `published` enum('0','1') NOT NULL DEFAULT '0' COMMENT 'published',
              `deleted` enum('0','1') NOT NULL DEFAULT '0' COMMENT 'deleted',
              `readonly` enum('0','1') NOT NULL DEFAULT '0' COMMENT 'readonly'
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='seo sitemap element';
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
                ADD  KEY `deleted` (`deleted`),
                ADD  KEY `published` (`published`),
                ADD  KEY `module_id` (`module_id`),
                ADD  KEY `model_id` (`model_id`);
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
