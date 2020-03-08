<?php

use yii\db\Migration;

/**
 * Class m160223_150422_add_column_layout_to_page
 *
 * @package thread\modules\page
 */
class m160223_150422_add_column_layout_to_page extends Migration
{
    public function up()
    {
        $this->addColumn('fv_page', 'layout', 'varchar(255) DEFAULT \'\' AFTER alias');
    }

    public function down()
    {
        $this->dropColumn('fv_page', 'layout');
    }
}
