<?php

use yii\db\Migration;

class m160407_150427_add_column_fake_fio_to_comment extends Migration
{
    public function up()
    {
        $this->addColumn('fv_sanatorium_comments', 'name' , 'varchar(255) NOT NULL DEFAULT \'\' COMMENT\'Фейк name (жульничаем)\'');
        $this->addColumn('fv_sanatorium_comments', 'surname' , 'varchar(255) NOT NULL DEFAULT \'\' COMMENT\'Фейк surname (жульничаем)\'');
    }

    public function down()
    {
        $this->dropColumn('fv_sanatorium_comments', 'name' );
        $this->dropColumn('fv_sanatorium_comments', 'surname' );
    }
}
