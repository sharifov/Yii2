<?php

use yii\db\Migration;

class m160215_142646_add_column_company_id_to_sanatorium extends Migration
{
    public function up()
    {
        $this->execute("
            ALTER TABLE `fv_sanatorium_sanatoriums`
                 ADD `company_id` int(11) unsigned DEFAULT NULL
         ");

        $this->execute("
            ALTER TABLE `fv_sanatorium_sanatoriums`
                 ADD KEY `company_id` (`company_id`)
         ");

        $this->execute("
            ALTER TABLE `fv_sanatorium_sanatoriums`
                 ADD CONSTRAINT `fv_company_ibfk_1` FOREIGN KEY (`company_id`) REFERENCES `fv_company` (`id`)
         ");
    }

    public function down()
    {

        $this->execute("
            ALTER TABLE `fv_sanatorium_sanatoriums`
                DROP FOREIGN KEY `fv_company_ibfk_1`
         ");


        $this->execute("
            ALTER TABLE `fv_sanatorium_sanatoriums`
                 DROP INDEX `company_id`
         ");

        $this->execute("
            ALTER TABLE `fv_sanatorium_sanatoriums`
                 DROP `company_id`
         ");

    }
}
