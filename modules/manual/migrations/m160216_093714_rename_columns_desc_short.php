<?php

use yii\db\Migration;

class m160216_093714_rename_columns_desc_short extends Migration
{
    public function up()
    {
        $this->execute("
           ALTER TABLE `fv_manual_areas_treatment_lang`
            CHANGE COLUMN `desc_short` `info` varchar(255) NOT NULL DEFAULT ''
         ");

        $this->execute("
           ALTER TABLE `fv_manual_facilities_rooms_lang`
            CHANGE COLUMN `desc_short` `info` varchar(255) NOT NULL DEFAULT ''
         ");

        $this->execute("
           ALTER TABLE `fv_manual_facilities_services_lang`
            CHANGE COLUMN `desc_short` `info` varchar(255) NOT NULL DEFAULT ''
         ");

        $this->execute("
           ALTER TABLE `fv_manual_services_lang`
            CHANGE COLUMN `desc_short` `info` varchar(255) NOT NULL DEFAULT ''
         ");

        $this->execute("
           ALTER TABLE `fv_company_transfer_lang`
            CHANGE COLUMN `desc_short` `info` varchar(255) NOT NULL DEFAULT ''
         ");

    }


    public function down()
    {
        $this->execute("
           ALTER TABLE `fv_manual_areas_treatment_lang`
            CHANGE COLUMN `info` `desc_short` varchar(255) NOT NULL DEFAULT ''
         ");

        $this->execute("
           ALTER TABLE `fv_manual_facilities_rooms_lang`
            CHANGE COLUMN `info` `desc_short` varchar(255) NOT NULL DEFAULT ''
         ");

        $this->execute("
           ALTER TABLE `fv_manual_facilities_services_lang`
            CHANGE COLUMN `info` `desc_short` varchar(255) NOT NULL DEFAULT ''
         ");

        $this->execute("
           ALTER TABLE `fv_manual_services_lang`
            CHANGE COLUMN `info` `desc_short` varchar(255) NOT NULL DEFAULT ''
         ");

        $this->execute("
           ALTER TABLE `fv_company_transfer_lang`
            CHANGE COLUMN `info` `desc_short` varchar(255) NOT NULL DEFAULT ''
         ");
    }

}
