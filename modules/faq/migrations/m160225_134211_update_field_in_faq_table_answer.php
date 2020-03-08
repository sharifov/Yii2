<?php

use yii\db\Migration;
use thread\modules\faq\Faq;

/**
 * Class m160225_134211_update_field_in_faq_table_answer
 *
 * @package thread\modules\faq
 */
class m160225_134211_update_field_in_faq_table_answer extends Migration {

    /**
     *
     * @var type
     */
    public $tableFaq = 'fv_faq';

    /**
     *
     */
    public function init() {
        $this->db = Faq::getDb();
        parent::init();
    }

    /**
     *
     */
    public function safeUp() {
        $this->execute("
            ALTER TABLE `" . $this->tableFaq . "` CHANGE `answer` `answer` VARCHAR(2048) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'answer';
        ");

        parent::safeUp();
    }

}
