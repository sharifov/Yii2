<?php

namespace thread\app\components\grid;

use yii\grid\CheckboxColumn;
use yii\helpers\Url;
use kartik\switchinput\SwitchInput;

/**
 *
 * Class SwitchboxColumn
 *
 * @package thread\app\components\grid
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c) 2015, Thread
 */
class SwitchboxColumn extends CheckboxColumn
{

    public $multiple = false;

    /**
     *
     * @var string
     */
    public $attribute;

    /**
     *
     * @var type
     */
    public $link;

    /**
     *
     * @throws InvalidConfigException
     */
    public function init()
    {
        parent::init();
        if (empty($this->attribute)) {
            throw new InvalidConfigException('The "name" property must be set.');
        }
    }

    /**
     *
     * @param type $model
     * @return type
     */
    protected function getLink($model)
    {
        if (!empty($this->link)) {
            if ($this->link instanceof \Closure) {
                $f = $this->link;
                return $f($model);
            } else {
                return $this->link;
            }
        } else {
            return Url::toRoute([$this->attribute, 'id' => $model->id, $this->attribute => $model[$this->attribute]]);
        }
    }

    /**
     * @inheritdoc
     */
    protected function renderDataCellContent($model, $key, $index)
    {

        return SwitchInput::widget([
                'name' => $this->attribute,
                'value' => $model[$this->attribute],
                'pluginEvents' => [
                    "switchChange.bootstrapSwitch" => "function(){ location.href='" . $this->getLink($model) . "' }",
                ],
            ]
        );
    }

}
