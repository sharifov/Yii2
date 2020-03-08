<?php

use yii\db\Migration;

class m160428_085536_upd_row_link_in_fv_widget_how_to_help extends Migration
{
    public function up()
    {
        $this->alterColumn('fv_widget_how_to_help', 'link', 'varchar(255) NOT NULL DEFAULT \'\' COMMENT\'link\'');
    }

    public function down()
    {
        $this->alterColumn('fv_widget_how_to_help', 'link', 'varchar(255) NOT NULL DEFAULT \'\' COMMENT\'link\'');
    }
}
