<?php

use yii\db\Migration;

class m160511_084935_add_columns_for_resort_rates extends Migration
{
    public $tableName = '{{%sanatorium_sanatoriums}}';

    public function safeUp()
    {
        $this->addColumn($this->tableName, 'include_resort_rate', $this->boolean()->notNull()->defaultValue(1) . ' COMMENT "Включает курортный сбор"');

    }

    public function down()
    {
        $this->dropColumn($this->tableName, 'include_resort_rate');
    }
}
