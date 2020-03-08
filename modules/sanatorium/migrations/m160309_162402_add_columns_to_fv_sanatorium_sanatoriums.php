<?php

use yii\db\Migration;

class m160309_162402_add_columns_to_fv_sanatorium_sanatoriums extends Migration
{
    public function up()
    {
        $this->addColumn('fv_sanatorium_sanatoriums_lang', 'review', 'text NOT NULL');
        $this->addColumn('fv_sanatorium_sanatoriums', 'youtube_link', 'varchar(255) NOT NULL AFTER gallery_link');
        $this->addColumn('fv_sanatorium_sanatoriums_lang', 'terms_of_payment', 'text NOT NULL');
        $this->addColumn('fv_sanatorium_sanatoriums', 'treatment_rating', 'DECIMAL(2,1) NOT NULL DEFAULT 0.0 AFTER youtube_link');
    }

    public function down()
    {
        $this->dropColumn('fv_sanatorium_sanatoriums_lang', 'review');
        $this->dropColumn('fv_sanatorium_sanatoriums', 'youtube_link');
        $this->dropColumn('fv_sanatorium_sanatoriums_lang', 'terms_of_payment');
        $this->dropColumn('fv_sanatorium_sanatoriums', 'treatment_rating');
    }
}
