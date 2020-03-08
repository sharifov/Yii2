<?php

use thread\modules\manual\Manual;
use yii\db\Migration;

class m160223_210739_create_table_fv_our_team_lang extends Migration
{
    /**
     *
     * @var type
     */
    public $tableManualAreastreatment = 'fv_manual_our_team';

    /**
     *
     * @var type
     */
    public $tableManualAreastreatmentLang = 'fv_manual_our_team_lang';

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
            CREATE TABLE `" . $this->tableManualAreastreatmentLang . "` (
                `rid` int(11) UNSIGNED NOT NULL COMMENT 'rid',
                `lang` varchar(5) NOT NULL COMMENT 'lang',
                `title` varchar(128) NOT NULL DEFAULT '' COMMENT 'title',
                `appointment` varchar(255) DEFAULT NULL COMMENT 'должность',
                `fio` varchar(255) DEFAULT NULL COMMENT 'fio'
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT=' Наша команда lang';
        ");

        parent::up();
    }

    /**
     *
     */
    public function safeUp() {

        $this->execute("
            ALTER TABLE `" . $this->tableManualAreastreatmentLang . "`
                ADD UNIQUE KEY `rid` (`rid`,`lang`);
        ");

        $this->execute("
            ALTER TABLE `" . $this->tableManualAreastreatmentLang . "`
                ADD CONSTRAINT `" . $this->tableManualAreastreatmentLang . "_ibfk_1` FOREIGN KEY (`rid`) REFERENCES `" . $this->tableManualAreastreatment . "` (`id`) ON DELETE CASCADE;
        ");

        parent::safeUp();
    }

    /**
     *
     */
    public function safeDown() {
        $this->delete($this->tableManualAreastreatmentLang);
        $this->dropTable($this->tableManualAreastreatmentLang);

        parent::safeDown();
    }
}
