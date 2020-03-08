<?php

use admin\modules\widgetsetting\Widgetsetting;
use yii\db\Migration;

/**
 * Handles the creation for table `table_fv_widget_choice_resort_lang`.
 */
class m160427_083440_create_table_fv_widget_choice_resort_lang extends Migration
{
    public $tableName = 'fv_widget_choice_resort';
    public $countyTableName = 'fv_widget_choice_resort_lang';


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
            CREATE TABLE `" . $this->countyTableName . "` (
                `rid` int(11) unsigned NOT NULL COMMENT 'rid',
                `lang` varchar(5) NOT NULL COMMENT 'lang',
                `content` text NOT NULL COMMENT 'content'
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Выбор курорта lang widget';
        ");

        parent::up();
    }

    /**
     *
     */
    public function safeUp()
    {

        $this->execute("
            ALTER TABLE `" . $this->countyTableName . "`
                ADD UNIQUE KEY `rid` (`rid`,`lang`);
        ");

        $this->execute("
            ALTER TABLE `" . $this->countyTableName . "`
                ADD CONSTRAINT `" . $this->countyTableName . "_ibfk_1` FOREIGN KEY (`rid`) REFERENCES `" . $this->tableName . "` (`id`) ON DELETE CASCADE;
        ");

        parent::safeUp();
    }

    /**
     *
     */
    public function safeDown()
    {
        $this->delete($this->countyTableName);
        $this->dropTable($this->countyTableName);

        parent::safeDown();
    }



}
