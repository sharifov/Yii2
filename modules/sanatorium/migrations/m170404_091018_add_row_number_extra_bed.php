<?php

use yii\db\Migration;

class m170404_091018_add_row_number_extra_bed extends Migration
{

    public $table = '{{%sanatorium_prices}}';

    /**
     *
     */
    public function up()
    {
        $this->addColumn($this->table, 'number_extra_bed', $this->integer(11)->defaultValue(1)->notNull());
//        $this->update($this->table, ['number_extra_bed' => 0], ['standard_bed' => 1]);
    }

    /**
     *
     */
    public function down()
    {
        $this->dropColumn($this->table, 'number_extra_bed');
    }

}
