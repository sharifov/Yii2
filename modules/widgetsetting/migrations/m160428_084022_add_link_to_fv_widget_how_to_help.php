<?php

use yii\db\Migration;

/**
 * Handles adding link_to_fv_widget_how to table `help`.
 */
class m160428_084022_add_link_to_fv_widget_how_to_help extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn('fv_widget_how_to_help', 'button_link', 'varchar(255) NOT NULL DEFAULT\'\' COMMENT\'Ссылка в кнопке\'');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropColumn('fv_widget_how_to_help', 'button_link');
    }
}
