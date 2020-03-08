<?php

use yii\db\Migration;
use thread\modules\manual\Manual;

class m160210_113543_create_t_fv_manual_facilities_rooms_lang extends Migration
{
    /**
     *
     * @var type
     */
    public $tableManualMain= 'fv_manual_facilities_rooms';

    /**
     *
     * @var type
     */
    public $tableManualLang = 'fv_manual_facilities_rooms_lang';

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
                `title` varchar(128) NOT NULL DEFAULT '' COMMENT 'title',
                `desc_short` varchar(255) DEFAULT NULL COMMENT 'short description'
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='location country lang';
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
