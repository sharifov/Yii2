<?php

use yii\db\Migration;

class m160418_120547_upd_row_date_in_fv_sanatorium_booking extends Migration
{
    public function up()
    {
        $this->dropColumn('fv_sanatorium_booking', 'date_begin');
        $this->dropColumn('fv_sanatorium_booking', 'date_end');
        $this->addColumn('fv_sanatorium_booking', 'date_begin', 'date COMMENT\'Дата начала заезда\'');
        $this->addColumn('fv_sanatorium_booking', 'date_end', 'date COMMENT\'Дата окончания\'');
    }

    public function down()
    {
        $this->dropColumn('fv_sanatorium_booking', 'date_begin');
        $this->dropColumn('fv_sanatorium_booking', 'date_end');
        $this->addColumn('fv_sanatorium_booking', 'date_begin', 'datetime COMMENT\'Дата начала заезда\'');
        $this->addColumn('fv_sanatorium_booking', 'date_end', 'datetime COMMENT\'Дата окончания\'');
    }

}
