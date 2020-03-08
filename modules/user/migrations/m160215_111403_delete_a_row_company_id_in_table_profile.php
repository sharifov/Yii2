<?php

use yii\db\Migration;

class m160215_111403_delete_a_row_company_id_in_table_profile extends Migration
{
    public function up()
    {
        $this->execute("
            ALTER TABLE `fv_user_profile`
                 DROP INDEX `company_id`,
                 DROP company_id
         ");

    }

    public function down()
    {
        $this->execute("
            ALTER TABLE `fv_user_profile`
                 ADD company_id int(11) DEFAULT NULL,
                 ADD KEY `company_id` (`company_id`)
         ");

    }

}
