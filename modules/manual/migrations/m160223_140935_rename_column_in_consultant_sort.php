<?php

use yii\db\Migration;

class m160223_140935_rename_column_in_consultant_sort extends Migration
{
    public function up()
    {
        $this->renameColumn('fv_manual_consultants', 'sort', 'position');

    }

    public function down()
    {
        $this->renameColumn('fv_manual_consultants', 'position', 'sort');
    }
}
