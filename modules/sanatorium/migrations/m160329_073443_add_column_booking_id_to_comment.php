<?php

use yii\db\Migration;

class m160329_073443_add_column_booking_id_to_comment extends Migration
{

    /**
     * @var string table name
     */
    public $tableName = '{{%sanatorium_comments}}';

    /**
     * @var string related booking table name
     */
    public $relatedBookingTableName = '{{%sanatorium_booking}}';

    public function safeUp()
    {
        $this->addColumn($this->tableName,
            'hash',
            'varchar(255) DEFAULT NULL COMMENT "Security hash" '
            );

        $this->addColumn(
            $this->tableName,
            'booking_id',
            'int(11) unsigned COMMENT "ID Бронировки" '
        );

        $this->addForeignKey(
            'fk_sanatorium_comments_booking_id_sanatorium_booking_id',
            $this->tableName,
            'booking_id',
            $this->relatedBookingTableName,
            'id',
            'CASCADE',
            'CASCADE'
        );
    }

    public function safeDown()
    {
        $this->dropForeignKey(
            'fk_sanatorium_comments_booking_id_sanatorium_booking_id',
            $this->tableName
        );
        $this->dropColumn($this->tableName, 'booking_id');
        $this->dropColumn($this->tableName, 'hash');
    }
}
