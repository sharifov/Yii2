<?php

use yii\db\Migration;

class m160216_123707_delete_column_in_fransger_alias extends Migration
{
    public function up()
    {
        $this->execute("
            ALTER TABLE `fv_company_transfer`
              DROP COLUMN `alias`
         ");
    }

    public function down()
    {
        $this->execute("
            ALTER TABLE `fv_company_transfer`
              ADD COLUMN `alias` VARCHAR(255) DEFAULT ''
         ");
    }
}
