<?php

use yii\db\Migration;
use thread\modules\manual\Manual;

class m160210_110317_create_t_fv_manual_areas_treatment_lang extends Migration
{
    /**
     *
     * @var type
     */
    public $tableManualAreastreatment = 'fv_manual_areas_treatment';

    /**
     *
     * @var type
     */
    public $tableManualAreastreatmentLang = 'fv_manual_areas_treatment_lang';

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
                `desc_short` varchar(255) DEFAULT NULL COMMENT 'short description',
                `meta_title ` varchar(255) DEFAULT NULL COMMENT 'short description',
                `meta_desc ` varchar(255) DEFAULT NULL COMMENT 'short description',
                `meta_keywords ` varchar(255) DEFAULT NULL COMMENT 'short description',
                `meta_h1 ` varchar(255) DEFAULT NULL COMMENT 'short description',
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='location country lang';
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
