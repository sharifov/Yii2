<?php

use yii\db\Migration;

class m160419_132754_change_index_in_fv_sanatorium_rel_manual_areas_treatment extends Migration
{
    public  $tableName = '{{%sanatorium_rel_manual_areas_treatment}}';
    public $firstIndexName = 'fv_manual_areas_treatment_ibfk_1';
    public $secondIndexName = 'fv_sanatorium_rel_manual_areas_treatment';

    public function up()
    {
        $this->dropForeignKey($this->firstIndexName, $this->tableName);
        $this->dropForeignKey($this->secondIndexName, $this->tableName);


        $this->addForeignKey(
            $this->firstIndexName,
            $this->tableName,
            'areas_treatment_id',
            'fv_manual_areas_treatment',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            $this->secondIndexName,
            $this->tableName,
            'sanatorium_id',
            'fv_sanatorium_sanatoriums',
            'id',
            'CASCADE'
        );

    }

    public function down()
    {
        $this->dropForeignKey($this->firstIndexName, $this->tableName);
        $this->dropForeignKey($this->secondIndexName, $this->tableName);

        $this->addForeignKey(
            $this->firstIndexName,
            $this->tableName,
            'areas_treatment_id',
            'fv_manual_areas_treatment',
            'id'
        );

        $this->addForeignKey(
            $this->secondIndexName,
            $this->tableName,
            'sanatorium_id',
            'fv_sanatorium_sanatoriums',
            'id'
        );

    }
}
