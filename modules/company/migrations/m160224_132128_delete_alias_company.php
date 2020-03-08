<?php

use yii\db\Migration;

class m160224_132128_delete_alias_company extends Migration
{
    public function up()
    {
        $this->execute("
            ALTER TABLE `fv_company`
              DROP COLUMN `alias`
         ");
    }

    public function down()
    {
        $this->execute("
            ALTER TABLE `fv_company`
              ADD COLUMN `alias` varchar(255) NOT NULL COMMENT 'alias'
         ");
    }


}
