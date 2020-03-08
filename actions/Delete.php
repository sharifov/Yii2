<?php

namespace thread\actions;

use Yii;
use yii\base\Exception;
use yii\web\Response;
use yii\log\Logger;
use thread\base\ActionCRUD;

/**
 * Class Delete
 * 
 * @package thread\actions
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c) 2015, Thread
 *
  public function actions() {
  return [
 * ...
  'delete' => [
  'class' => Delete::class,
  'modelClass' => Model::class,
  'attribute' => 'delete'
  ],
 * ...
  ];
  }
 *
 */
class Delete extends ActionCRUD {

    public $redirect = ['trash'];

    public function init() {

        if ($this->modelClass === null)
            throw new Exception(__CLASS__ . '::$modelClass must be set.');

        $this->model = new $this->modelClass;

        if ($this->model === null)
            throw new Exception($this->modelClass . '::$modelClass must be set.');
    }

    public function run($id) {

        $delete = false;

        if ($model = $this->findModel($id)) {

            $transaction = $model::getDb()->beginTransaction();

            try {
                $delete = $model->delete();
                ($delete) ? $transaction->commit() : $transaction->rollBack();
            } catch (Exception $e) {
                throw new \Exception($e);
                Yii::getLogger()->log($e->getMessage(), Logger::LEVEL_ERROR);
                $transaction->rollBack();
            }
        }

        if (Yii::$app->getRequest()->isAjax) {
            Yii::$app->getResponse()->format = Response::FORMAT_JSON;
            return $delete;
        } else {
            $this->controller->redirect($this->getRedirect());
        }
    }

}
