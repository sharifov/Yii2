<?php

use yii\db\Migration;

class m160216_090505_switch_index_langTable extends Migration
{
    private $table = 'fv_location_city';
    private $tableLang = 'fv_location_city_lang';


    public function up()
    {
        $this->execute("
            ALTER TABLE `". $this->tableLang ."`
                DROP FOREIGN KEY `" .$this->tableLang ."_ibfk_1`
         ");

        $this->execute("
              ALTER TABLE `". $this->tableLang ."`
                 ADD CONSTRAINT `". $this->tableLang ."_ibfk_1` FOREIGN KEY (`rid`) REFERENCES `". $this->table ."` (`id`)
                 ON DELETE CASCADE ON UPDATE RESTRICT
         ");
    }

    public function down()
    {
        $this->execute("
              ALTER TABLE `". $this->tableLang ."`
                 ADD CONSTRAINT `". $this->tableLang ."_ibfk_1` FOREIGN KEY (`rid`) REFERENCES `". $this->table ."` (`id`)
                 ON DELETE CASCADE ON UPDATE RESTRICT
         ");
    }

}
