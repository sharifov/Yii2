<?php

use yii\db\Migration;

/**
 * Handles adding bigger_symbol to table `content`.
 */
class m160425_124254_add_bigger_symbol_to_content extends Migration
{
    public function up()
    {
        $this->alterColumn('fv_manual_our_team_lang', 'content', 'text NOT NULL DEFAULT \'\' COMMENT \'Описанин\'');
    }


    public function down()
    {
        $this->alterColumn('fv_manual_our_team_lang', 'content', 'varchar(2048) NOT NULL DEFAULT \'\' COMMENT \'Описанин\'');
    }
}
