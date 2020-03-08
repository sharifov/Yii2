<?php

namespace thread\actions;

use Yii;
use yii\base\Action;
use yii\base\Exception;
use yii\web\NotFoundHttpException;
use yii\web\Response;

/**
 * Class RecordView
 * 
 * @package thread\actions
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c) 2015, Thread
 *
  public function actions() {
  return [
 * ...
  'view' => [
  'class' => RecordView::class,
  'query' => Model::findOne(),
  ],
 * ...
  ];
  }
 *
 */
class RecordView extends Action {

    /**
     * Базовий layout
     * @var string
     */


    /**
     * Відображення
     * @var string
     */
    public $view = 'view';

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
    public $methodName = null;

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

    public function run($alias) {

        $ref = new \ReflectionMethod($this->model, $this->methodName);
        $model = $ref->invoke($this->model, $alias);

        if ($model === null)
            throw new NotFoundHttpException;

        if (Yii::$app->getRequest()->isAjax) {
            Yii::$app->getResponse()->format = Response::FORMAT_JSON;
            return $this->controller->renderPartial($this->view, [
                        'model' => $model,
            ]);
        } else {

            return $this->controller->render($this->view, [
                        'model' => $model,
            ]);
        }
    }

}
