<?php

use yii\db\Migration;

/**
 * Handles adding column_resort_rate to table `lang`.
 */
class m160511_095930_add_column_resort_rate_to_lang extends Migration
{
    public $tableName = '{{%sanatorium_sanatoriums_lang}}';

    public function safeUp()
    {
        $this->addColumn($this->tableName, 'resort_rate', $this->string(255)->defaultValue(null) . ' COMMENT "Курортный сбор"');

    }

    public function down()
    {
        $this->dropColumn($this->tableName, 'resort_rate');
    }
}
