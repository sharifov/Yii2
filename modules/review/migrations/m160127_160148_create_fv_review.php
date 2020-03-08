<?php

use yii\db\Migration;
use thread\modules\review\Review;

/**
 * Class m160127_160148_create_fv_review
 *
 * @package thread\modules\review
 * @author zndron
 * @copyright (c) 2016, Thread
 */
class m160127_160148_create_fv_review extends Migration
{
    /**
     *
     * @var type
     */
    public $tableReview = 'fv_review';

    /**
     *
     */
    public function init()
    {

        $this->db = Review::getDb();
        parent::init();
    }

    /**
     *
     */
    public function up()
    {
        $this->execute("
            CREATE TABLE `" . $this->tableReview . "` (
                `id` int(11) UNSIGNED NOT NULL COMMENT 'id',
                `user_id` int(11) UNSIGNED NOT NULL DEFAULT '0' COMMENT 'user_id',
                `item_id` int(11) NOT NULL COMMENT 'item_id',
                `title` varchar(255) NOT NULL COMMENT 'title',
                `description` varchar(1024) NOT NULL COMMENT 'description',
                `create_time` int(11) UNSIGNED NOT NULL DEFAULT '0' COMMENT 'create_time',
                `update_time` int(11) UNSIGNED NOT NULL DEFAULT '0' COMMENT 'update_time',
                `published` enum('0','1') NOT NULL DEFAULT '0' COMMENT 'published',
                `deleted` enum('0','1') NOT NULL DEFAULT '0' COMMENT 'deleted',
                `ratingValue` float UNSIGNED NOT NULL DEFAULT '0' COMMENT 'ratingValue',
                `ratingCount` int(11) UNSIGNED NOT NULL DEFAULT '0' COMMENT 'ratingCount'
            ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='review';
        ");

        parent::up();
    }

    /**
     *
     */
    public function safeUp()
    {
        $this->execute("
            ALTER TABLE `" . $this->tableReview . "`
                ADD PRIMARY KEY (`id`),
                ADD KEY `deleted` (`deleted`),
                ADD KEY `published` (`published`),
                ADD KEY `item_id` (`item_id`),
                ADD KEY `user_id` (`user_id`);
        ");

        $this->execute("
            ALTER TABLE `" . $this->tableReview . "`
                MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'id', AUTO_INCREMENT=1;
        ");

        parent::safeUp();
    }

    /**
     *
     */
    public function safeDown()
    {
        $this->delete($this->tableReview);
        $this->dropTable($this->tableReview);

        parent::safeDown();
    }
}
