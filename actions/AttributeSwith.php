<?php

namespace thread\actions;

use Yii;
use yii\base\Exception;
use yii\web\Response;
use yii\log\Logger;
use thread\base\ActionCRUD;
use thread\models\ActiveRecord;

/**
 * Class AttributeSwith
 * 
 * @package thread\actions
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c) 2015, Thread
 *
  public function actions() {
  return [
 * ...
  'published' => [
  'class' => AttributeKeySwith::class,
  'modelClass' => Model::class,
  'attribute' => 'published'
  ],
 * ...
  ];
  }
 *
 */
class AttributeSwith extends ActionCRUD {

    /**
     * Атрибут моделі
     * @var string
     */
    public $attribute;

    /**
     *
     * @var array|string| typeof Closure
     */
    public $redirect = ['list'];

    /**
     * @var ActiveRecord
     */
    protected $model = null;

    public function init() {

        if ($this->modelClass === null)
            throw new Exception(__CLASS__ . '::$modelClass must be set.');

        $this->model = new $this->modelClass;

        if ($this->model === null)
            throw new Exception($this->modelClass . 'must be exists.');

        if (!$this->model->is_attribute($this->attribute))
            throw new Exception($this->modelClass . '::' . $this->attribute . ' attribute doesn\'t exist');

        if (!$this->model->is_scenario($this->attribute))
            throw new Exception($this->modelClass . '::' . $this->attribute . ' scenario doesn\'t exist');
    }

    public function run($id) {

        $save = $this->save($id);

        if (Yii::$app->getRequest()->isAjax) {
            Yii::$app->getResponse()->format = Response::FORMAT_JSON;
            return $save;
        } else {
            $this->controller->redirect($this->getRedirect());
        }
    }

    /**
     * Зберігає дані моделі
     * @param integer $id
     * @return boollean
     */
    protected function save($id) {

        $save = false;

        if ($model = $this->findModel($id)) {
            $model->setScenario($this->attribute);

            $model->{$this->attribute} = ($model->{$this->attribute} === ActiveRecord::STATUS_KEY_ON) ? ActiveRecord::STATUS_KEY_OFF : ActiveRecord::STATUS_KEY_ON;

            $transaction = $model::getDb()->beginTransaction();

            try {
                $save = $model->save();
                ($save) ? $transaction->commit() : $transaction->rollBack();
            } catch (Exception $e) {
                Yii::getLogger()->log($e->getMessage(), Logger::LEVEL_ERROR);
                $transaction->rollBack();
            }
        }

        return $save;
    }

}
