<?php

use yii\db\Migration;

class m160223_195719_add_column_to_fv_company_transfer_company_address_www_bookiang extends Migration
{
    public function up()
    {
        $this->addColumn('fv_company_transfer_company', 'address_www_booking', 'varchar(255) DEFAULT NULL');
    }

    public function down()
    {
        $this->dropColumn('fv_company_transfer_company', 'address_www_booking');
    }
}
