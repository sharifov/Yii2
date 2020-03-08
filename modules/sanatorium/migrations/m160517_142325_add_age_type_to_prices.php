<?php

use yii\db\Migration;

/**
 * Handles adding age_type to table `prices`.
 */
class m160517_142325_add_age_type_to_prices extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->alterColumn('fv_sanatorium_prices', 'age', 'enum(\'Adult\', \'Young\', \'Teen\',\'Child\') NOT NULL DEFAULT \'Adult\' COMMENT \'Возраст(Взсрослый >= 18 лет, Young 17 - 12, Teen 11 -6, Child 2-5 )\'');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->alterColumn('fv_sanatorium_prices', 'age', 'enum(\'Adult\',\'Teen\',\'Child\') NOT NULL DEFAULT \'Adult\' COMMENT \'Возраст(Взсрослый > 11 лет,Teen 11 -6, Child 2-5 )\'');
    }
}
