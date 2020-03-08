<?php

use yii\db\Migration;

class m160223_122726_delete_column_alis_in_medical_base extends Migration
{
    public function up()
    {
        $this->dropColumn('fv_manual_medical_base', 'alias');

    }

    public function down()
    {
        $this->addColumn('fv_manual_medical_base', 'alias', 'varchar(255)');
    }

}
