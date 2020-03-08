<?php

namespace thread\actions;

use Yii;
use yii\base\Exception;
use yii\web\NotFoundHttpException;
use yii\log\Logger;
use thread\base\ActionCRUD;

/**
 * Class Update
 *
 * @package thread\actions
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c) 2015, Thread
 *
 * public function actions() {
 * return [
 * ...
 * 'create' => [
 * 'class' => Update::class,
 * 'modelClass' => Model::class,
 * ],
 * ...
 * ];
 * }
 *
 */
class Update extends ActionCRUD
{

    /**
     *
     * @var typeof Closure
     */
    public $afterSave = '';

    /**
     * @throws Exception
     */
    public function init()
    {
        if ($this->modelClass === null)
            throw new Exception(__CLASS__ . '::$modelClass must be set.');

        $this->model = new $this->modelClass;

        if ($this->model === null)
            throw new Exception($this->modelClass . 'must be exists.');

        if (!$this->model->is_scenario($this->scenario))
            throw new Exception($this->modelClass . '::' . $this->scenario . ' scenario doesn\'t exist');
    }

    /**
     * @param int $id
     * @return string|\yii\web\Response
     * @throws \Throwable
     */
    public function run(int $id)
    {
        if (Yii::$app->getRequest()->isAjax) {
            return $this->controller->renderPartial($this->view, [
                'model' => $this->model,
            ]);
        } else {
            if ($this->saveModel($id)) {
                $this->afterSaveModel();
                return $this->controller->redirect($this->getRedirect());
            } else {

                $this->controller->layout = $this->layout;

                return $this->controller->render($this->view, [
                    'model' => $this->model,
                ]);
            }
        }
    }

    /**
     * Збереження данних до бази даних
     * Має бути встановдений у моделі scenario 'backend'
     *
     * @param int $id
     * @param string $className
     * @return bool
     * @throws \Throwable
     */
    public function saveModel($id, $className = '')
    {
        $save = false;
        $this->model = $this->findModel($id, $className);

        if ($this->model === null) {
            throw new NotFoundHttpException();
        }

        $this->model->setScenario($this->scenario);

        if ($this->model->load(Yii::$app->getRequest()->post())) {
            $model = $this->model;
            $transaction = $model::getDb()->beginTransaction();
            try {
                $save = $this->model->save();

                ($save) ? $transaction->commit() : $transaction->rollBack();
            } catch (Exception $e) {
                Yii::getLogger()->log($e->getMessage(), Logger::LEVEL_ERROR);
                $transaction->rollBack();
            }
        }

        return $save;
    }

    /**
     *
     */
    public function afterSaveModel()
    {
        $s = $this->afterSave;
        if ($s instanceof \Closure) {
            return $s();
        }
    }

}
