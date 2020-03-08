<?php

use yii\db\Migration;

class m160311_155054_add_column_to_menu_item_parent_id extends Migration
{
    public function up()
    {
        $this->addColumn('fv_menu_item', 'parent_id', 'int(11) unsigned DEFAULT 0');
    }

    public function down()
    {
        $this->dropColumn('fv_menu_item', 'parent_id');
    }
}
