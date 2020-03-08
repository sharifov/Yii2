<?php

use yii\db\Migration;

/**
 * Handles adding column_currency_id to table `fv_sanatorium_prices`.
 */
class m160419_082535_add_column_currency_id_to_fv_sanatorium_prices extends Migration
{

    public $tableName = '{{%sanatorium_booking}}';
    public $relatedBookingTableName = '{{%location_currency}}';
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn($this->tableName, 'currency_id', 'int(11) unsigned NOT NULL COMMENT\'Пользовательская валюта\'');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropColumn($this->tableName, 'currency_id');
    }
}
