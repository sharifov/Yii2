<?php

use thread\modules\widgetsetting\Widgetsetting;
use yii\db\Migration;

class m160321_150257_create_table_fv_widget_how_to_help_lang extends Migration
{
    /**
     *
     * @var type
     */
    public $tableSanatorium = 'fv_widget_how_to_help';

    /**
     *
     * @var type
     */
    public $tableSanatoriumLang = 'fv_widget_how_to_help_lang';



    public function init() {

        $this->db = Widgetsetting::getDb();
        parent::init();
    }

    /**
     *
     */
    public function up()
    {
        $this->execute("
            CREATE TABLE `" . $this->tableSanatoriumLang . "` (
                `rid` int(11) unsigned NOT NULL COMMENT 'rid',
                `lang` varchar(5) NOT NULL COMMENT 'lang',
                `title` varchar(255) NOT NULL COMMENT 'title',
                `info` varchar(255) NOT NULL COMMENT 'короткое описание',
                `btn_name` varchar(255) NOT NULL COMMENT 'надпись на кнопке'
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='lang widget, (Как мы можем вам помочь)';
        ");

        parent::up();
    }

    /**
     *
     */
    public function safeUp()
    {

        $this->execute("
            ALTER TABLE `" . $this->tableSanatoriumLang . "`
                ADD UNIQUE KEY `rid` (`rid`,`lang`);
        ");

        $this->execute("
            ALTER TABLE `" . $this->tableSanatoriumLang . "`
                ADD CONSTRAINT `" . $this->tableSanatoriumLang . "_ibfk_1` FOREIGN KEY (`rid`) REFERENCES `" . $this->tableSanatorium . "` (`id`) ON DELETE CASCADE;
        ");

        parent::safeUp();
    }

    /**
     *
     */
    public function safeDown()
    {
        $this->delete($this->tableSanatoriumLang);
        $this->dropTable($this->tableSanatoriumLang);

        parent::safeDown();
    }
}
