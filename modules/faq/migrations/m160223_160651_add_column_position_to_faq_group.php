<?php

use yii\db\Migration;

/**
 * Class m160223_160651_add_column_position_to_faq_group
 *
 * @package thread\modules\faq
 */
class m160223_160651_add_column_position_to_faq_group extends Migration
{
    public function up()
    {
        $this->addColumn('fv_faq_group', 'position', 'int(11) DEFAULT 0 AFTER title');
    }

    public function down()
    {
        $this->dropColumn('fv_faq_group', 'position');
    }
}
