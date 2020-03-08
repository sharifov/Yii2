<?php

use yii\db\Migration;

class m160519_085928_rename_row_card_email_in_booking extends Migration
{
    public function up()
    {
        $this->alterColumn('fv_sanatorium_booking', 'card_email'  , 'varchar(255) DEFAULT NULL COMMENT \'Имя на карте\'');
        $this->renameColumn('fv_sanatorium_booking', 'card_email' , 'card_name');
    }

    public function down()
    {
        $this->renameColumn('fv_sanatorium_booking', 'card_name' , 'card_email');
    }

}
