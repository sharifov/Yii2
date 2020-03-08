<?php

use thread\modules\sanatorium\Sanatorium;
use yii\db\Migration;

class m160219_145544_create_fv_sanatorium_sanatoriums_many_to_many_manual_medical_base extends Migration
{
    /**
     *
     * @var type
     */
    public $tableSanatorium = 'fv_sanatorium_sanatoriums_many_to_many_manual_medical_base';

    /**
     *
     */
    public function init() {

        $this->db = Sanatorium::getDb();
        parent::init();
    }

    /**
     *
     */
    public function up() {
        $this->execute("
          CREATE TABLE `". $this->tableSanatorium ."` (
              `id` int(11) unsigned NOT NULL COMMENT 'id',
              `sanatorium_id` int(11) unsigned DEFAULT NULL COMMENT 'санаторий_id',
              `medical_base_id` int(11) unsigned DEFAULT NULL COMMENT 'медецинская база id'
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='многие ко многим санатории и лечебные базы';
        ");

        parent::up();
    }

    /**
     *
     */
    public function safeUp() {

        $this->execute("
            ALTER TABLE `". $this->tableSanatorium ."`
                ADD UNIQUE KEY `id` (`id`);
        ");

        $this->execute("
            ALTER TABLE `" . $this->tableSanatorium . "`
                MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'id', AUTO_INCREMENT=1;
        ");

        parent::safeUp();
    }

    /**
     *
     */
    public function safeDown() {
        $this->dropTable($this->tableSanatorium);

        parent::safeDown();
    }
}
