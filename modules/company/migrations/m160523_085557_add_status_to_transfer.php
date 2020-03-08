<?php

use yii\db\Migration;

/**
 * Handles adding status to table `transfer`.
 */
class m160523_085557_add_status_to_transfer extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn('fv_company_transfer_orders', 'status', 'enum(\'booked\',\'cancelled\') NOT NULL DEFAULT \'booked\' COMMENT \'booked - забронирован cancelled - отменен \'');
        $this->addColumn('fv_company_transfer_orders', 'cancellation_date', ' int(11) unsigned NOT NULL DEFAULT \'0\' COMMENT \'дата анулирования бронирования\'');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropColumn('fv_company_transfer_orders', 'status');
        $this->dropColumn('fv_company_transfer_orders', 'cancellation_date');
    }
}
