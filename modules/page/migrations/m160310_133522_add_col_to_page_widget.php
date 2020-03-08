<?php

use yii\db\Migration;

class m160310_133522_add_col_to_page_widget extends Migration
{
    public function up()
    {
        $this->addColumn('fv_page', 'widget', 'varchar(255) NOT NULL DEFAULT \'\'  COMMENT \'Полный путь к виджету\'');
    }

    public function down()
    {
        $this->dropColumn('fv_page', 'widget');
    }
}
