<?php

use yii\db\Migration;

class m160223_124204_delete_column_alias_in_consultant extends Migration
{
    public function up()
    {
        $this->dropColumn('fv_manual_consultants', 'alias');

    }

    public function down()
    {
        $this->addColumn('fv_manual_consultants', 'alias', 'varchar(255)');
    }
}
