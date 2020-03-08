<?php

use yii\db\Migration;

/**
 * Handles adding row_yoytube_image to table `sanatoriums`.
 */
class m160630_154640_add_row_yoytube_image_to_sanatoriums extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn('fv_sanatorium_sanatoriums', 'youtube_image', 'varchar(255) NOT NULL DEFAULT \'\' COMMENT\'youtube_image\'');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropColumn('fv_sanatorium_sanatoriums', 'youtube_image');
    }
}
