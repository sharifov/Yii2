<?php

use yii\db\Migration;

class m160316_154344_update_row_advantages_in_fv_sanatorium_sanatoriums_langa extends Migration
{
    public function up()
    {
        $this->dropColumn('fv_sanatorium_sanatoriums_lang', 'advantages');
        $this->addColumn('fv_sanatorium_sanatoriums_lang', 'advantages', 'text NOT NULL');

    }

    public function down()
    {
        $this->dropColumn('fv_sanatorium_sanatoriums_lang', 'advantages');
        $this->addColumn('fv_sanatorium_sanatoriums_lang', 'advantages', 'text NOT NULL');
    }
}
