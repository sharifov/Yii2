<?php

use yii\db\Migration;

/**
 * Handles adding col_children_age_id to table `price`.
 */
class m160831_100512_add_col_children_age_id_to_price extends Migration
{

    /**
     * @var string
     */
    public $tablePrice = '{{%sanatorium_prices}}';

    public $tableSanatorium = '{{%sanatorium_sanatoriums}}';

    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn('fv_sanatorium_prices', 'children_age_id', 'int(11) unsigned DEFAULT NULL  COMMENT\'Возраст ребенка (NULL - Взрослый)\'');

//        /** rel with table catalog_category */
//        $this->addForeignKey(
//            'fk-sana_price_child_age_id-san_children_age_sanatorium_id',
//            $this->tablePrice,
//            'children_age_id',
//            $this->tableSanatorium,
//            'id',
//            'CASCADE',
//            'CASCADE'
//        );
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
//        $this->dropForeignKey('fk-sana_price_child_age_id-san_children_age_sanatorium_id', $this->tablePrice);
        $this->dropColumn('fv_sanatorium_prices', 'children_age_id');
    }
}
