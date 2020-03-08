<?php

use yii\db\Migration;

class m160325_153522_add_column_non_card_booking_to_sanatoriums extends Migration
{

    public $tableName = '{{%sanatorium_sanatoriums}}';

    public function up()
    {
        $this->addColumn($this->tableName, 'non_card_booking', " enum('0','1') NOT NULL DEFAULT '0' COMMENT 'Бронирование без КК' ");
    }

    public function down()
    {
        $this->dropColumn($this->tableName, 'non_card_booking');
    }

}
