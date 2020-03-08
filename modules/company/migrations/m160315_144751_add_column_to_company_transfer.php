<?php

use yii\db\Migration;

class m160315_144751_add_column_to_company_transfer extends Migration
{
    public function up()
    {
        $this->dropColumn('fv_company_transfer', 'type_transfer');
        $this->addColumn('fv_company_transfer', 'type', 'enum(\'group\',\'personal\') NOT NULL DEFAULT \'group\' COMMENT \'Тип трансфера\' AFTER sanatoriums_id');
    }

    public function down()
    {
        $this->addColumn('fv_company_transfer', 'type_transfer', 'enum(\'групповой\',\'персональный\') NOT NULL DEFAULT \'групповой\' COMMENT \'Тип трансфера\' AFTER sanatoriums_id');
        $this->dropColumn('fv_company_transfer', 'type');
    }
}
