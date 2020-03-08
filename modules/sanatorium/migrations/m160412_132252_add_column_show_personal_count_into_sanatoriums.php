<?php

use yii\db\Migration;

class m160412_132252_add_column_show_personal_count_into_sanatoriums extends Migration
{
    public $tableName = '{{%sanatorium_sanatoriums}}';

    public function up()
    {
        $this->addColumn($this->tableName, 'show_personal_count', $this->boolean()->notNull()->defaultValue(0) . ' COMMENT "Show staff count"');
    }

    public function down()
    {
        $this->dropColumn($this->tableName, 'show_personal_count');
    }

}
