<?php

namespace thread\actions;

use Yii;
use yii\base\Action;
use yii\helpers\VarDumper;
use yii\web\Response;
use yii\base\Exception;

/**
 * Class ListModel
 * 
 * @package thread\actions
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c) 2015, Thread
 *
  public function actions() {
  return [
 * ...
  'list' => [
  'class' => DataProviderList::class,
  'modelClass' => Model::class,
  'methodName' => 'search',
  ],
 * ...
  ];
  }
 *
 */
class ListModel extends Action {

    /**
     * Базовий layout
     * @var string
     */
    public $layout = '@app/layouts/list';

    /**
     * Відображення
     * @var string
     */
    public $view = 'list';

    /**
     * Назва моделі з якою будемо працювати
     * модель має наслідувати ActiveRecord
     * @var string
     */
    public $modelClass = null;

    /**
     * Назва методу моделі для отримання даних
     * @var string
     */
    public $methodName = 'search';

    /**
     * Перевірка на дозвіл
     * @var boollean false|true
     */
    public $checkAccess = false;

    /**
     * @var ActiveRecord
     */
    protected $model = null;

    public function init() {
        if ($this->modelClass === null)
            throw new Exception(__CLASS__ . '::$modelClass must be set.');

        $this->model = new $this->modelClass;

        if ($this->model === null)
            throw new Exception($this->modelClass . ' must be exists.');

        if (!method_exists($this->model, $this->methodName))
            throw new Exception($this->modelClass . '::' . $this->methodName . ' must be exists.');
    }

    public function run() {

        $this->controller->layout = $this->layout;

        if (Yii::$app->getRequest()->isAjax) {
            Yii::$app->getResponse()->format = Response::FORMAT_JSON;

            return $this->controller->renderPartial($this->view, [
                        'model' => $this->model,
            ]);
        } else {
            $this->controller->layout = $this->layout;
//
//            VarDumper::dump( $this->controller->layout);
//            die();

            return $this->controller->render($this->view, [
                        'model' => $this->model,
            ]);
        }
    }

}
