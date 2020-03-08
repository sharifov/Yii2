<?php

use yii\db\Migration;

class m160314_133827_add_column_to_company_transfer extends Migration
{
    public function up()
    {
        $this->dropColumn('fv_company_transfer_lang', 'start_transfer');
        $this->dropColumn('fv_company_transfer_lang', 'end_transfer');
        $this->addColumn('fv_company_transfer', 'start_transfer', 'int(11) DEFAULT 0 AFTER sanatoriums_id');
        $this->addColumn('fv_company_transfer', 'end_transfer', 'int(11) DEFAULT 0 AFTER start_transfer');
    }

    public function down()
    {
        $this->addColumn('fv_company_transfer_lang', 'start_transfer', 'varchar(255) NOT NULL');
        $this->addColumn('fv_company_transfer_lang', 'end_transfer', 'varchar(255) NOT NULL');

        $this->dropColumn('fv_company_transfer', 'start_transfer');
        $this->dropColumn('fv_company_transfer', 'end_transfer');
    }
}
