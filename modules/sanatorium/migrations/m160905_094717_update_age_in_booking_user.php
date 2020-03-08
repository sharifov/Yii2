<?php

use yii\db\Migration;

class m160905_094717_update_age_in_booking_user extends Migration
{
    public function up()
    {
        $this->alterColumn('fv_sanatorium_booking_users', 'age', 'int(11) NOT NULL COMMENT\'Возраст\'');
    }

    public function down()
    {
        $this->alterColumn('fv_sanatorium_booking_users', 'age', 'enum(\'Adult\',\'Teen\',\'Child\') NOT NULL DEFAULT \'Adult\' COMMENT \'Возраст(Взсрослый > 11 лет,Teen 11 -6, Child 2-5 )\'');
    }

    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }

    public function safeDown()
    {
    }
    */
}
