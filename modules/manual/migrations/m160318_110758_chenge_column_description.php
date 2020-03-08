<?php

use yii\db\Migration;

class m160318_110758_chenge_column_description extends Migration
{
    public function up()
    {
        $this->dropColumn('fv_manual_our_team_lang', 'info');
        $this->addColumn('fv_manual_our_team_lang', 'content', 'varchar(2048) NOT NULL DEFAULT \'\' COMMENT \'Описанин\'');
    }

    public function down()
    {
        $this->dropColumn('fv_manual_our_team_lang', 'content');
        $this->dropColumn('fv_manual_our_team_lang', 'info', 'varchar(2048) NOT NULL DEFAULT \'\' COMMENT \'Описанин\'');
    }

}
