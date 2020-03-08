<?php

use yii\db\Migration;

class m160309_135750_add_column_to_outteam_col_position extends Migration
{
    public function up()
    {
        $this->addColumn('fv_manual_our_team', 'position', 'int(11) NOT NULL DEFAULT 0');
    }

    public function down()
    {
        $this->dropColumn('fv_manual_our_team', 'position');
    }
}
