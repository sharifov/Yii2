<?php

use thread\modules\sanatorium\Sanatorium;
use yii\db\Migration;

class m160225_093007_create_table_fv_sanatorium_rel_manual_medical_office extends Migration
{
    /**
     *
     * @var type
     */
    public $table = 'fv_sanatorium_rel_manual_medical_office';

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
           CREATE TABLE `fv_sanatorium_rel_manual_medical_office` (
              `id` int(11) unsigned NOT NULL COMMENT 'id',
              `sanatorium_id` int(11) unsigned NOT NULL COMMENT 'sanatorium_id',
              `medical_office_id` int(11) unsigned NOT NULL COMMENT 'Удобство номера',
              `number_people` int(11) NOT NULL COMMENT 'Количество человек'
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Rel санаторий - удобство номера';
        ");

        $this->execute("
            ALTER TABLE `fv_sanatorium_rel_manual_medical_office`
                      ADD PRIMARY KEY (`id`),
                      ADD KEY `fv_sanatorium_sanatoriums_ibfk_1` (`sanatorium_id`),
                      ADD KEY `fv_manual_medical_office_ibfk_1` (`medical_office_id`);
        ");

        $this->execute("
            ALTER TABLE `fv_sanatorium_rel_manual_medical_office`
                MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'id', AUTO_INCREMENT=1;
        ");


        $this->execute("
            ALTER TABLE `fv_sanatorium_rel_manual_medical_office`
               ADD CONSTRAINT `fv_manual_medical_office_ibfk_1` FOREIGN KEY (`medical_office_id`) REFERENCES `fv_manual_medical_office` (`id`)
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
