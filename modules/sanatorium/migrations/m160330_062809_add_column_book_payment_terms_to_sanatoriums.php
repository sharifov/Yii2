<?php

use yii\db\Migration;

class m160330_062809_add_column_book_payment_terms_to_sanatoriums extends Migration
{

    public $tableName = '{{%sanatorium_sanatoriums_lang}}';

    public function safeUp()
    {
        $this->addColumn($this->tableName, 'booking_payment_terms', 'text DEFAULT NULL COMMENT "Booking terms of payments"');
    }

    public function safeDown()
    {
        $this->dropColumn($this->tableName, 'booking_payment_terms');
    }
}
