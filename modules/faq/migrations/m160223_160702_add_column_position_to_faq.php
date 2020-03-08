<?php

use yii\db\Migration;

/**
 * Class m160223_160702_add_column_position_to_faq
 *
 * @package thread\modules\faq
 */
class m160223_160702_add_column_position_to_faq extends Migration
{
    public function up()
    {
        $this->addColumn('fv_faq', 'position', 'int(11) DEFAULT 0 AFTER answer');
    }

    public function down()
    {
        $this->dropColumn('fv_faq', 'position');
    }
}
