<?php

use yii\db\Migration;

class m160215_111910_add_to_user_company_id_AND_sanatorium_id extends Migration
{
    public function up()
    {
        $this->execute("
            ALTER TABLE `fv_user`
                 ADD `company_id` int(11) DEFAULT NULL,
                 ADD `sanatorium_id` int(11) DEFAULT NULL
         ");

    }

    public function down()
    {
        $this->execute("
            ALTER TABLE `fv_user`
                 DROP `company_id`,
                 DROP `sanatorium_id`
         ");
    }
}
