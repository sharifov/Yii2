<?php

use yii\db\Migration;
use thread\modules\faq\Faq;

/**
 * Class m160218_153656_create_fv_faq_group_table
 *
 * @package thread\modules\faq
 */
class m160218_153656_create_fv_faq_group_table extends Migration
{
    /**
     *
     * @var type
     */
    public $tableFaqgroup = 'fv_faq_group';

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
            CREATE TABLE `" . $this->tableFaqgroup . "` (
                `id` int(11) unsigned NOT NULL COMMENT 'id',
                `lang` varchar(5) NOT NULL COMMENT 'lang',
                `title` varchar(255) NOT NULL COMMENT 'title',
                `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT 'create_time',
                `update_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT 'update_time',
                `published` enum('0','1') NOT NULL DEFAULT '0' COMMENT 'published',
                `deleted` enum('0','1') NOT NULL DEFAULT '0' COMMENT 'deleted'
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='faq group';
        ");

        parent::up();
    }

    /**
     *
     */
    public function safeUp()
    {
        $this->execute("
            ALTER TABLE `" . $this->tableFaqgroup . "`
                ADD PRIMARY KEY (`id`),
                ADD UNIQUE KEY `id` (`id`,`lang`),
                ADD KEY `deleted` (`deleted`),
                ADD KEY `published` (`published`);
        ");

        $this->execute("
            ALTER TABLE `" . $this->tableFaqgroup . "`
                MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'id', AUTO_INCREMENT=1;
        ");

        parent::safeUp();
    }

    /**
     *
     */
    public function safeDown()
    {
        $this->delete($this->tableFaqgroup);
        $this->dropTable($this->tableFaqgroup);

        parent::safeDown();
    }
}
