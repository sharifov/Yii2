<?php

use yii\db\Migration;
use thread\modules\faq\Faq;

/**
 * Class m160209_110250_create_fv_faq_table
 *
 * @package thread\modules\faq
 */
class m160209_110250_create_fv_faq_table extends Migration
{
    /**
     *
     * @var type
     */
    public $tableFaq = 'fv_faq';

    /**
     *
     */
    public function init()
    {
        $this->db = Faq::getDb();
        parent::init();
    }

    /**
     *
     */
    public function up()
    {
        $this->execute("
            CREATE TABLE `" . $this->tableFaq . "` (
                `id` int(11) unsigned NOT NULL COMMENT 'id',
                `lang` varchar(5) NOT NULL COMMENT 'lang',
                `group_id` int(11) UNSIGNED NOT NULL COMMENT 'group',
                `question` varchar(525) NOT NULL COMMENT 'question',
                `answer` varchar(2024) NOT NULL COMMENT 'answer',
                `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT 'create_time',
                `update_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT 'update_time',
                `published` enum('0','1') NOT NULL DEFAULT '0' COMMENT 'published',
                `deleted` enum('0','1') NOT NULL DEFAULT '0' COMMENT 'deleted'
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='faq';
        ");

        parent::up();
    }

    /**
     *
     */
    public function safeUp()
    {

        $this->execute("
            ALTER TABLE `" . $this->tableFaq . "`
                ADD PRIMARY KEY (`id`),
                ADD UNIQUE KEY `id` (`id`,`lang`),
                ADD KEY `deleted` (`deleted`),
                ADD KEY `published` (`published`);
        ");

        $this->execute("
            ALTER TABLE `" . $this->tableFaq . "`
                MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'id', AUTO_INCREMENT=1;
        ");

        parent::safeUp();
    }

    /**
     *
     */
    public function safeDown()
    {
        $this->delete($this->tableFaq);
        $this->dropTable($this->tableFaq);

        parent::safeDown();
    }
}
