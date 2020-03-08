<?php

use yii\db\Migration;

class m160304_132907_add_column_to_fv_manual_rooms_position extends Migration
{
    public function up()
    {
        $this->addColumn('fv_manual_rooms', 'position', 'int(11) NOT NULL DEFAULT 0');
        $this->dropColumn('fv_manual_rooms', 'alias');
    }

    public function down()
    {
        $this->addColumn('fv_manual_rooms', 'alias', 'varchar(255) DEFAULT \'\' ');
        $this->dropColumn('fv_manual_rooms', 'position');
    }
}
