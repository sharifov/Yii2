<?php

use yii\db\Migration;

class m160309_140328_add_column_to_outteam_lang_col_info_and_del_title extends Migration
{
    public function up()
    {
        $this->dropColumn('fv_manual_our_team_lang', 'title');
        $this->addColumn('fv_manual_our_team_lang', 'info', 'varchar(255) NOT NULL DEFAULT \'\'');
    }

    public function down()
    {
        $this->dropColumn('fv_manual_our_team_lang', 'info');
        $this->addColumn('fv_manual_our_team_lang', 'title', 'varchar(255) NOT NULL DEFAULT \'\'');

    }
}
