<?php

use yii\db\Migration;

/**
 * Handles adding currency_id to table `transferorder`.
 */
class m160629_153723_add_currency_id_to_transferOrder extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn('fv_company_transfer_orders', 'currency_id', 'int(11) unsigned NOT NULL DEFAULT 0 COMMENT\'Курс валюты\'');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropColumn('fv_company_transfer_orders', 'currency_id');
    }
}
