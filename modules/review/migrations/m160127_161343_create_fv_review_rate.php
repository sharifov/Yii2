<?php

use yii\db\Migration;
use thread\modules\review\Review;

/**
 * Class m160127_161343_create_fv_review_rate
 *
 * @package thread\modules\review
 * @author zndron
 * @copyright (c) 2016, Thread
 */

class m160127_161343_create_fv_review_rate extends Migration
{
    /**
     *
     * @var type
     */
    public $tableReviewRating = 'fv_review_rate';

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
            CREATE TABLE `" . $this->tableReviewRating . "` (
                `id` int(11) UNSIGNED NOT NULL COMMENT 'id',
                `item_id` int(11) UNSIGNED NOT NULL COMMENT 'article_id',
                `user_id` int(11) UNSIGNED NOT NULL COMMENT 'user_id',
                `rate` enum('1','2','3','4','5') NOT NULL DEFAULT '1' COMMENT 'rate',
                `create_time` int(11) UNSIGNED NOT NULL DEFAULT '0' COMMENT 'create_time',
                `update_time` int(11) UNSIGNED NOT NULL DEFAULT '0' COMMENT 'update_time'
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
        ");

        parent::up();
    }

    /**
     *
     */
    public function safeUp()
    {
        $this->execute("
            ALTER TABLE `" . $this->tableReviewRating . "`
                ADD PRIMARY KEY (`id`),
                ADD UNIQUE KEY `article_id_2` (`item_id`,`user_id`),
                ADD KEY `article_id` (`item_id`),
                ADD KEY `user_id` (`user_id`)
        ");

        $this->execute("
            ALTER TABLE `" . $this->tableReviewRating . "`
                MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'id', AUTO_INCREMENT=1;
        ");

        parent::safeUp();
    }

    /**
     *
     */
    public function safeDown()
    {
        $this->delete($this->tableReviewRating);
        $this->dropTable($this->tableReviewRating);

        parent::safeDown();
    }
}
