<?php

use yii\db\Migration;
use thread\modules\faq\Faq;

/**
 * Class m160209_110343_create_fv_faq_insert_info
 *
 * @package thread\modules\faq
 */
class m160209_110343_create_fv_faq_insert_info extends Migration
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
    public function safeUp()
    {
        $this->execute("
            INSERT INTO `" . $this->tableFaq . "` (`id`, `lang`, `group_id`, `question`, `answer`, `create_time`, `update_time`, `published`, `deleted`) VALUES
                (1, 'ru-RU', 0, 'Lorem ipsum dolor sit amet, consectetur adipisicing elit?', '<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint</p>', 0, 1454343971, '1', '0'),
                (2, 'ru-RU', 0, 'sdf', '<p>sdf</p>', 1454344642, 1454344685, '0', '0');
        ");

        parent::safeUp();
    }

    /**
     *
     */
    public function safeDown()
    {
        $this->delete($this->tableFaq);

        parent::safeDown();
    }
}
