<?php

use yii\db\Migration;

/**
 * Handles adding row_currency to table `sanatorium`.
 */
class m160525_094603_add_row_currency_to_sanatorium extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn('fv_sanatorium_sanatoriums', 'currency_id',
            'int(11) unsigned DEFAULT NULL COMMENT \'Валюта санаторий\'');

        $this->addForeignKey(
            'fv_sanatorium_sanatoriums_fv_company_transfer_ibfk_1',
            'fv_sanatorium_sanatoriums',
            'currency_id',
            'fv_location_currency',
            'id'
        );
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropColumn('fv_sanatorium_sanatoriums', 'currency_id');
    }
}
