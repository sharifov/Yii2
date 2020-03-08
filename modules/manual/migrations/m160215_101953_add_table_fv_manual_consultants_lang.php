<?php

use yii\db\Migration;
use thread\modules\manual\Manual;

class m160215_101953_add_table_fv_manual_consultants_lang extends Migration
{
    /**
     *
     * @var type
     */
    public $tableManualMain= 'fv_manual_consultants';

    /**
     *
     * @var type
     */
    public $tableManualLang = 'fv_manual_consultants_lang';

    /**
     *
     */
    public function init() {

        $this->db = Manual::getDb();
        parent::init();
    }

    /**
     *
     */
    public function up() {
        $this->execute("
            CREATE TABLE `" . $this->tableManualLang . "` (
                `rid` int(11) UNSIGNED NOT NULL COMMENT 'rid',
                `lang` varchar(5) NOT NULL COMMENT 'lang',
                `fio` varchar(255) NOT NULL DEFAULT '' COMMENT 'fio',
                `specialization` varchar(255) NOT NULL DEFAULT '' COMMENT 'специализация'
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='location consultants lang';
        ");

        parent::up();
    }

    /**
     *
     */
    public function safeUp() {

        $this->execute("
            ALTER TABLE `" . $this->tableManualLang . "`
                ADD UNIQUE KEY `rid` (`rid`,`lang`);
        ");

        $this->execute("
            ALTER TABLE `" . $this->tableManualLang . "`
                ADD CONSTRAINT `" . $this->tableManualLang . "_ibfk_1` FOREIGN KEY (`rid`) REFERENCES `" . $this->tableManualMain . "` (`id`) ON DELETE CASCADE;
        ");

        parent::safeUp();
    }

    /**
     *
     */
    public function safeDown() {
        $this->delete($this->tableManualLang);
        $this->dropTable($this->tableManualLang);

        parent::safeDown();
    }
}
