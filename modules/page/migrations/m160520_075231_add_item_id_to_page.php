<?php

use yii\db\Migration;

/**
 * Handles adding item_id to table `page`.
 */
class m160520_075231_add_item_id_to_page extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn('fv_page', 'item_id', 'int(11) NOT NULL DEFAULT 0 COMMENT \'для страниц второго уровня \'');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropColumn('fv_page', 'item_id');
    }
}
