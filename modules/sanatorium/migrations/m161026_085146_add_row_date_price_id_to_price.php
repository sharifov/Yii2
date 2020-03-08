<?php

use yii\db\Migration;

/**
 * Handles adding row_date_price_id to table `price`.
 */
class m161026_085146_add_row_date_price_id_to_price extends Migration
{

    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn('fv_sanatorium_prices', 'date_price_id', 'int(11) unsigned DEFAULT NULL  COMMENT \'Даты\'');

        $this->addForeignKey(
            'fv_sanatorium_prices-date_price_id-date_price-id',
            'fv_sanatorium_prices',
            'date_price_id',
            'fv_sanatorium_dates_price',
            'id',
            'CASCADE',
            'CASCADE'
        );
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropForeignKey('fv_sanatorium_prices-date_price_id-date_price-id', 'fv_sanatorium_prices');
        $this->dropColumn('fv_sanatorium_prices', 'date_price_id');
    }
}
