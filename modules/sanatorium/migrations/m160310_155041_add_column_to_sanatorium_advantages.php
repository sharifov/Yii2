<?php

use yii\db\Migration;

class m160310_155041_add_column_to_sanatorium_advantages extends Migration
{
    public function up()
    {
        $this->addColumn('fv_sanatorium_sanatoriums_lang', 'advantages', 'varchar(2048) NOT NULL DEFAULT \'\' COMMENT \'Преймущества\'');
    }

    public function down()
    {
        $this->dropColumn('fv_sanatorium_sanatoriums_lang', 'advantages');
    }
}
