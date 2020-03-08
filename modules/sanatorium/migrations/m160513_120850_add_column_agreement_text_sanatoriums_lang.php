<?php

use yii\db\Migration;

class m160513_120850_add_column_agreement_text_sanatoriums_lang extends Migration
{

    public $tableName = '{{%sanatorium_sanatoriums_lang}}';

    public function safeUp()
    {
        $this->addColumn($this->tableName, 'agreement_text', $this->text()->defaultValue(null) . ' COMMENT "Agreement text"');
    }

    public function safeDown()
    {
        $this->dropColumn($this->tableName, 'agreement_text');
    }
}
