<?php

use yii\db\Migration;

/**
 * Handles adding type_discount to table `sanatorium`.
 */
class m160519_092457_add_type_discount_to_sanatorium extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn('fv_sanatorium_sanatoriums', 'type_discount', ' enum(\'for days\',\'before arrival\', \'days-arrival\')
        NOT NULL DEFAULT \'for days\'
        COMMENT \'for days - На дни проживания, before arrival - на дни до приезда, days-arrival - Считаеться for days + before arrival\'');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropColumn('fv_sanatorium_sanatoriums', 'type_discount');
    }
}
