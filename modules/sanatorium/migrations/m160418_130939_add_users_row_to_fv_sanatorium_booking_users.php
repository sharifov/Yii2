<?php

use yii\db\Migration;

/**
 * Handles adding users_row to table `fv_sanatorium_booking_users`.
 */
class m160418_130939_add_users_row_to_fv_sanatorium_booking_users extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn('fv_sanatorium_booking_users', 'type_food', 'enum(\'FBT\', \'HBT\',\'HB\',\'FB\') NOT NULL DEFAULT \'FBT\' COMMENT \'Тип питания\'');
        $this->addColumn('fv_sanatorium_booking_users', 'age', 'enum(\'Adult\', \'Teen\',\'Child\') NOT NULL DEFAULT \'Adult\' COMMENT \'Возраст(Взсрослый > 11 лет,Teen 11 -6, Child 2-5 )\'');
        $this->addColumn('fv_sanatorium_booking_users', 'standard_bed', 'enum(\'0\', \'1\') NOT NULL DEFAULT \'0\' COMMENT \'Стандартная кровать?\'');
        $this->addColumn('fv_sanatorium_booking_users', 'extra_bed', 'enum(\'0\', \'1\') NOT NULL DEFAULT \'0\' COMMENT \'Дополнительная кровать?\'');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropColumn('fv_sanatorium_booking_users', 'type_food');
        $this->dropColumn('fv_sanatorium_booking_users', 'age');
        $this->dropColumn('fv_sanatorium_booking_users', 'standard_bed');
        $this->dropColumn('fv_sanatorium_booking_users', 'extra_bed');
    }
}
