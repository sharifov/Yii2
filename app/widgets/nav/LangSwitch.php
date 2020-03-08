<?php

namespace thread\app\widgets\nav;

use thread\components\MultiLanguage;
use thread\models\Lang;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

/**
 * Class LangSwitch
 *
 * @package thread\app\widgets\nav
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c) 2015, Thread
 *
 * <?= LangSwitch::widget();?>
 *
 */
class LangSwitch extends \yii\bootstrap\Widget {

    protected $current = null;
    protected $items = null;
    public $view = 'LangSwitch';

    public function init() {
        if (MultiLanguage::MULTI == MultiLanguage::KEY_ON) {
            $this->items = Lang::getList();
            $this->current = Lang::getCurrent();

            unset($this->items[$this->current->alias]);
        }
    }

    public function run() {
        if (MultiLanguage::MULTI == MultiLanguage::KEY_ON) {

            $items = [];
            $url = \Yii::$app->getRequest()->getBaseUrl();

            $resolve = \Yii::$app->request->resolve();
            $resolveParams = strstr(Url::to(ArrayHelper::merge( [$resolve[0]], $resolve[1])), '?');

            foreach ($this->items as $lang) {
                if ($lang->default !== '1')
                    $items[] = [
                        'label' => $lang->title,
                        'url' => $url .  '/' . $lang->alias . '/' . \Yii::$app->request->pathInfo . $resolveParams
                    ];
                else
                    $items[] = [
                        'label' => $lang->title,
                        'url' => $url . '/' . \Yii::$app->request->pathInfo . $resolveParams
                    ];
            }

            return $this->render($this->view, [
                        'current' => $this->current,
                        'items' => $items,
            ]);
        }
    }

}
