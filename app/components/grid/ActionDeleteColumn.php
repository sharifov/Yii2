<?php

namespace thread\app\components\grid;

use Yii;
use yii\helpers\Html;

/**
 * Class ActionDeleteColumn
 * 
 * @package thread\app\components\grid
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c) 2015, Thread
 */
class ActionDeleteColumn extends \yii\grid\Column {

    /**
     *
     * @var type 
     */
    public $link;

    /**
     * 
     * @param type $model
     * @return type
     */
    protected function getLink($model) {
        if (!empty($this->link)) {
            if ($this->link instanceof \Closure) {
                $f = $this->link;
                return $f($model);
            } else {
                $r = ['delete'];
                foreach ($this->link as $data) {
                    $r[$data] = $model->$data;
                }

                return $r;
            }
        } else {
            return ['delete', 'id' => $model->id];
        }
    }

    /**
     * @inheritdoc
     */
    protected function renderDataCellContent($model, $key, $index) {

        return Html::a(Yii::t('app', 'action_delete'), $this->getLink($model));
    }

}
