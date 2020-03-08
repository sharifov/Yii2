<?php

use yii\db\Migration;

class m160225_143205_update_faq_row_question extends Migration
{
    public function up()
    {
        $this->dropColumn('fv_faq', 'answer');
        $this->addColumn('fv_faq', 'answer', 'text');
    }

    public function down()
    {
        $this->dropColumn('fv_faq', 'answer');
        $this->addColumn('fv_faq', 'answer', 'varchar(2048) NOT NULL');

    }

}
