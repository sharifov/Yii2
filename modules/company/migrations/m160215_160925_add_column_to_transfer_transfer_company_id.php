<?php

use yii\db\Migration;

class m160215_160925_add_column_to_transfer_transfer_company_id extends Migration
{
    public function up()
    {
        $this->execute("
            ALTER TABLE `fv_company_transfer`
                 ADD `transfer_company_id` int(11) unsigned DEFAULT NULL
         ");

        $this->execute("
            ALTER TABLE `fv_company_transfer`
                 ADD KEY `transfer_company_id` (`transfer_company_id`)
         ");

        $this->execute("
            ALTER TABLE `fv_company_transfer`
                 ADD CONSTRAINT `fv_company_transfer_company_ibfk_1` FOREIGN KEY (`transfer_company_id`) REFERENCES `fv_company_transfer_company` (`id`)
         ");
    }

    public function down()
    {
        $this->execute("
            ALTER TABLE `fv_sanatorium_sanatoriums`
                DROP FOREIGN KEY `fv_company_transfer_company_ibfk_1`
         ");

        $this->execute("
            ALTER TABLE `fv_sanatorium_sanatoriums`
                 DROP INDEX `transfer_company_id`
         ");

        $this->execute("
            ALTER TABLE `fv_sanatorium_sanatoriums`
                 DROP `transfer_company_id`
         ");
    }
}
