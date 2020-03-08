<?php

use yii\db\Migration;

class m160527_092734_add_to_comments_professionalism_doctor extends Migration
{
    public function up()
    {
        $this->addColumn('fv_sanatorium_comments',
            'professionalism_doctor',
            'float NOT NULL DEFAULT \'0\' COMMENT \'профессионализм врача во время лечения\'');

        $this->addColumn('fv_sanatorium_total_comments',
            'total_professionalism_doctor',
            'float NOT NULL DEFAULT \'0\' COMMENT \'профессионализм врача во время лечения\'');

    }

    public function down()
    {
        $this->dropColumn('fv_sanatorium_comments', 'professionalism_doctor');
        $this->dropColumn('fv_sanatorium_total_comments', 'total_professionalism_doctor');
    }

}
