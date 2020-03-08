<?php

use yii\db\Migration;

class m160401_080535_add_columns_to_prices extends Migration
{
    private $table = '{{%sanatorium_prices}}';

    public function up()
    {
        $this->addColumn($this->table, 'extra_bed', 'enum(\'0\', \'1\') NOT NULL DEFAULT \'0\' COMMENT \'Дополнительная кровать?\' ');
        $this->addColumn($this->table, 'standard_bed', 'enum(\'0\', \'1\') NOT NULL DEFAULT \'0\' COMMENT \'Стандартная кровать?\' ');
        $this->addColumn($this->table, 'type_food', 'enum(\'FBT\', \'HBT\', \'HB\') NOT NULL DEFAULT \'FBT\' COMMENT \'Тип питания\' ');
        $this->addColumn($this->table, 'age', 'enum(\'Adult\', \'Teen\', \'Child\') NOT NULL DEFAULT \'Adult\' COMMENT \'Возраст(Взсрослый > 11 лет,Teen 11 -6, Child 2-5 )\'');
        $this->addColumn($this->table, 'min_days', 'int(11) NOT NULL DEFAULT 0 COMMENT \'Минимальное кол-во дней проживания\' ');
        $this->addColumn($this->table, 'bank_card', 'enum(\'0\', \'1\') NOT NULL DEFAULT \'0\' COMMENT \'Банковская карта обязательна?\'');
        $this->addColumn($this->table, 'number_rooms', 'int(11) NOT NULL DEFAULT 0 COMMENT \'Количество номеров для бронирования\' ');
    }

    public function down()
    {
        $this->dropColumn($this->table, 'extra_bed');
        $this->dropColumn($this->table, 'standard_bed');
        $this->dropColumn($this->table, 'type_food');
        $this->dropColumn($this->table, 'age');
        $this->dropColumn($this->table, 'min_days');
        $this->dropColumn($this->table, 'bank_card');
        $this->dropColumn($this->table, 'number_rooms');
    }
}
