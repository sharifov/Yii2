<?php

use yii\db\Migration;

class m160324_095631_add_column_to_fv_sanatorium_booking extends Migration
{
    public function up()
    {
        $this->addColumn('fv_sanatorium_booking', 'name', 'varchar(255) NOT NULL DEFAULT \'\' COMMENT \'Имя для связи насчет бронирования \'');
        $this->addColumn('fv_sanatorium_booking', 'surname', 'varchar(255) NOT NULL DEFAULT \'\' COMMENT \'Фамилия для связи насчет бронирования \'');
        $this->addColumn('fv_sanatorium_booking', 'country_id', 'int(11) unsigned NOT NULL  COMMENT \'Страна (оформляющего заказ)\'');

    }

    public function down()
    {
        $this->dropColumn('fv_sanatorium_booking', 'name');
        $this->dropColumn('fv_sanatorium_booking', 'surname');
        $this->dropColumn('fv_sanatorium_booking', 'country_id');
    }
}
