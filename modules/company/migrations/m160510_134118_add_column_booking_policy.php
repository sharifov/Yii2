<?php

use yii\db\Migration;

class m160510_134118_add_column_booking_policy extends Migration
{
    public $tableName = '{{%company_transfer_lang}}';

    public function safeUp()
    {
        $this->addColumn($this->tableName, 'booking_policy', $this->text()->defaultValue(null) . ' COMMENT "Условия бронирования"');
    }

    public function safeDown()
    {
        $this->dropColumn($this->tableName, 'booking_policy');
    }
}
