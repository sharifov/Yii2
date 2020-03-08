<?php

use thread\modules\sanatorium\Sanatorium;
use yii\db\Migration;

class m160303_121944_create_table_fv_sanatorium_rel_manul_areas_treatment extends Migration
{
    /**
     *
     * @var type
     */
    public $table = 'fv_sanatorium_rel_manual_areas_treatment';

    /**
     *
     */
    public function init()
    {
        $this->db = Sanatorium::getDb();
        parent::init();
    }

    /**
     *
     */
    public function up()
    {
        $this->execute("
           CREATE TABLE `fv_sanatorium_rel_manual_areas_treatment` (
              `id` int(11) unsigned NOT NULL COMMENT 'id',
              `sanatorium_id` int(11) unsigned NOT NULL COMMENT 'sanatorium_id',
              `areas_treatment_id` int(11) unsigned NOT NULL COMMENT 'sanatorium_id',
              `is_main` int(1) unsigned NOT NULL DEFAULT 0 COMMENT 'Основное направление',
              `is_secondary` int(1) unsigned NOT NULL DEFAULT 0 COMMENT 'Второстепеное направление'
            ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='Rel санаторий - Направлений лечения';
        ");

        $this->execute("
            ALTER TABLE `fv_sanatorium_rel_manual_areas_treatment`
                      ADD PRIMARY KEY (`id`),
                      ADD KEY `fv_sanatorium_sanatoriums_ibfk_1` (`sanatorium_id`),
                      ADD KEY `fv_manual_areas_treatment_ibfk_1` (`areas_treatment_id`);
        ");

        $this->execute("
            ALTER TABLE `fv_sanatorium_rel_manual_areas_treatment`
                MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'id', AUTO_INCREMENT=1;
        ");


        $this->execute("
            ALTER TABLE `fv_sanatorium_rel_manual_areas_treatment`
               ADD CONSTRAINT `fv_sanatorium_rel_manual_areas_treatment` FOREIGN KEY (`sanatorium_id`) REFERENCES `fv_sanatorium_sanatoriums` (`id`),
               ADD CONSTRAINT `fv_manual_areas_treatment_ibfk_1` FOREIGN KEY (`areas_treatment_id`) REFERENCES `fv_manual_areas_treatment` (`id`)
        ");

        parent::up();
    }

    /**
     *
     */
    public function safeDown()
    {
        $this->delete($this->table);
        $this->dropTable($this->table);

        parent::safeDown();
    }
}
