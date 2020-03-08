<?php

use yii\db\Migration;

/**
 * Handles adding column_booking_basket_id to table `fv_sanatorium_booking_users`.
 */
class m160419_092019_add_column_booking_basket_id_to_fv_sanatorium_booking_users extends Migration
{

    public $tableName = '{{%sanatorium_booking_users}}';
    public $relatedBookingTableName = '{{%sanatorium_booking_basket}}';
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn($this->tableName, 'booking_basket_id', 'int(11) unsigned NOT NULL COMMENT\'Заброинированая комната\'');
        $this->addForeignKey(
            'fk_booking_users_fk_sanatorium_booking_basket',
            $this->tableName,
            'booking_basket_id',
            $this->relatedBookingTableName,
            'id',
            'CASCADE'
        );
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropForeignKey('fk_booking_users_fk_sanatorium_booking_basket', $this->tableName);
        $this->dropColumn($this->tableName, 'booking_basket_id');
    }
}
