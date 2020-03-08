<?php

use yii\db\Migration;

class m160215_103224_add_index_to_user_group extends Migration
{
    public function up()
    {
        $this->execute("
            ALTER TABLE `fv_user_profile`
                 ADD KEY `company_id` (`company_id`)
         ");
    }

    public function down()
    {
        $this->execute("
            ALTER TABLE `fv_user_profile`
                 DROP INDEX `company_id`
         ");
    }
}
