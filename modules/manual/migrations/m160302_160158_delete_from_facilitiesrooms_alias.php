<?php

use yii\db\Migration;

class m160302_160158_delete_from_facilitiesrooms_alias extends Migration
{
    public function up()
    {
        $this->dropColumn('fv_manual_facilities_rooms', 'alias');
    }

    public function down()
    {
        $this->addColumn('fv_manual_facilities_rooms', 'alias', ' varchar(255) NOT NULL ');
    }
}
