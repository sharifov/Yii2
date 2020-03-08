<?php

use yii\db\Migration;

class m160428_152635_add_column_btn_type extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn('fv_widget_how_to_help', 'link_type', 'enum("link", "popup") DEFAULT "link" COMMENT\'Тип ссылки\'');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropColumn('fv_widget_how_to_help', 'link_type');
    }
}
