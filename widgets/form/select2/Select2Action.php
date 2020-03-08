<?php

namespace thread\widgets\form\select2;

use Yii;
use yii\base\Action;
use yii\base\Exception;
use yii\web\Response;

/**
 * Class Select2Action
 * @package thread\widgets\form\select2
 * @author Filament
 * @copyright (c) 2015, Thread
 * @version 07/02/2015
 * 
  public function actions() {
  return [
 * ...
  'selected' => [
    'class' => Create::className(),
    'modelClass' => Model::className(),
  ],
 * ...
  ];
  }
 *
 */
class Select2Action extends Action {

    /**
     * Атрибут моделі - дані, що використовуються, як ключ
     * @var string 
     */
    public $return_key = 'id';

    /**
     * Атрибут моделі - дані, що використовуються, як назва
     * @var string 
     */
    public $return_title = 'title';

    /**
     * Атрибут, по якому проводиться пошук
     * @var string 
     */
    public $attribute = 'title';

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
     * Назва моделі з якою будемо працювати
     * модель має наслідувати \yii\db\ActiveRecord
     * @var string 
     */
    public $modelClass = null;

    /**
     * @var \yii\db\ActiveRecord 
     */
    protected $model = null;

    /**
     * @inheritdoc
     */
    public function init() {

        if ($this->modelClass === null)
            throw new Exception(__CLASS__ . '::$modelClass must be set.');

        $this->model = new $this->modelClass;

        if ($this->model === null)
            throw new Exception($this->modelClass . 'must be exists.');
    }

    /**
     * @inheritdoc
     */
    public function run($search = null) {

        Yii::$app->getResponse()->format = Response::FORMAT_JSON;

        $return = array();
        $s = new $this->model;
        $d = $s->{$this->methodName}([$this->attribute => $search]);
        foreach ($d->getModels() as $m)
            $return[] = ['id' => $m[$this->return_key], 'text' => $m[$this->return_title]];

        return $return;
    }

}
