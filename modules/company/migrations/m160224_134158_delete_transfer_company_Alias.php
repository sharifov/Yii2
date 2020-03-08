<?php

use yii\db\Migration;

class m160224_134158_delete_transfer_company_Alias extends Migration
{
    public function up()
    {
        $this->execute("
            ALTER TABLE `fv_company_transfer_company`
              DROP COLUMN `alias`
         ");

        $this->execute("
            ALTER TABLE `fv_company_transfer_company`
              ADD KEY `country_id` (`country_id`),
              ADD KEY `city_id` (`city_id`)
         ");
    }

    public function down()
    {

        $this->execute("
            ALTER TABLE `fv_company_transfer_company`
              ADD COLUMN `alias`
         ");

        $this->execute("
            ALTER TABLE `fv_company_transfer_company`
              DROP KEY `country_id` (`country_id`),
              DROP KEY `city_id` (`city_id`)
         ");
    }

}
