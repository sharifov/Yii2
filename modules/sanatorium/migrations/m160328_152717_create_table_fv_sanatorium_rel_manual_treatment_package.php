<?php

use thread\modules\sanatorium\Sanatorium;
use yii\db\Migration;

class m160328_152717_create_table_fv_sanatorium_rel_manual_treatment_package extends Migration
{
    /**
     *
     * @var type
     */
    public $tableSanatorium = 'fv_sanatorium_rel_treatment_package';


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
          CREATE TABLE `" . $this->tableSanatorium . "` (
              `id` int(11) unsigned NOT NULL  COMMENT 'id',

               `sanatorium_id`  int(11) unsigned NOT NULL COMMENT 'санаторий',
               `treatment_package_id`  int(11) unsigned NOT NULL COMMENT 'лечебный пакет',

               `value` float(12) NOT NULL DEFAULT '0' COMMENT 'значение пакета (осмотров)',
               `type` enum('0','1','3','7','10') NOT NULL DEFAULT '0' COMMENT 'тип пакета (на сколько дней рассчитан)'

            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Скидки в санатории';
        ");

        parent::up();
    }

    /**
     *
     */
    public function safeUp()
    {

        $this->execute("
            ALTER TABLE `" . $this->tableSanatorium . "`
                   ADD PRIMARY KEY (`id`)
        ");

        $this->execute("
            ALTER TABLE `" . $this->tableSanatorium . "`
                MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'id', AUTO_INCREMENT=1;
        ");

        $this->addForeignKey($this->tableSanatorium .'__sanatoriums_ibfk_1', $this->tableSanatorium , 'sanatorium_id', 'fv_sanatorium_sanatoriums', 'id', 'CASCADE');
        $this->addForeignKey($this->tableSanatorium .'_treatment_package_ibfk_1', $this->tableSanatorium , 'treatment_package_id', 'fv_manual_treatment_package', 'id', 'CASCADE');


        parent::safeUp();
    }

    /**
     *
     */
    public function safeDown()
    {
        $this->dropTable($this->tableSanatorium);
        parent::safeDown();
    }
}
