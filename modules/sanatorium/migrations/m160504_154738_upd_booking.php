<?php

use yii\db\Migration;

class m160504_154738_upd_booking extends Migration
{
    public function up()
    {
        $this->alterColumn('fv_sanatorium_booking', 'card_number', 'varchar(100) DEFAULT NULL COMMENT \'номер карты клинта\'');
        $this->alterColumn('fv_sanatorium_booking', 'card_type', 'varchar(100) DEFAULT NULL COMMENT \'card_type\'');
        $this->alterColumn('fv_sanatorium_booking', 'card_email', 'varchar(255) DEFAULT NULL COMMENT \'email\'');
        $this->alterColumn('fv_sanatorium_booking', 'card_year', 'int(11)  DEFAULT NULL COMMENT \'срок действия до (года)\'');
        $this->alterColumn('fv_sanatorium_booking', 'card_month', 'int(11)  DEFAULT NULL COMMENT \'срок действия до (месяца)\'');
    }

    public function down()
    {
        $this->alterColumn('fv_sanatorium_booking', 'card_number', 'varchar(100) DEFAULT NULL COMMENT \'номер карты клинта\'');
        $this->alterColumn('fv_sanatorium_booking', 'card_type', 'varchar(100) DEFAULT NULL COMMENT \'card_type\'');
        $this->alterColumn('fv_sanatorium_booking', 'card_email', 'varchar(255) DEFAULT NULL COMMENT \'email\'');
        $this->alterColumn('fv_sanatorium_booking', 'card_year', 'int(11)  DEFAULT NULL COMMENT \'срок действия до (года)\'');
        $this->alterColumn('fv_sanatorium_booking', 'card_month', 'int(11)  DEFAULT NULL COMMENT \'срок действия до (месяца)\'');

    }

}
