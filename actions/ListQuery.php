<?php

namespace thread\actions;

use Yii;
use yii\base\Action;
use yii\base\Exception;
use yii\web\Response;
use yii\data\ActiveDataProvider;
use thread\components\Pagination;

/**
 * Class ListQuery
 *
 * @package thread\actions
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c) 2015, Thread
 *
  public function actions() {
  return [
 * ...
  'list' => [
  'class' => QueryList::class,
  'query' => $model::find(),
  'recordOnPage' => 10
  ],
 * ...
  ];
  }
 *
 */
class ListQuery extends Action {

    /**
     * Базовий layout
     * @var string
     */


    /**
     * Відображення
     * @var string
     */
    public $view = 'list';

    /**
     * Перевірка на дозвіл
     * @var boollean false|true
     */
    public $checkAccess = false;

    /**
     * @var ActiveQuery
     */
    public $query = null;

    /**
     * Кількість моделей на сторінку
     * @var integer
     */
    public $recordOnPage = -1;

    /**
     *
     * @var string
     */
    public $sort = '';

    public function init() {

        if ($this->query === null) {
            throw new Exception('::Query must be set.');
        }
    }

    public function run() {

        $data = new ActiveDataProvider([
            'query' => $this->query,
            'pagination' => [
                'class' => Pagination::class,
                'pageSize' => $this->recordOnPage
            ]
        ]);
        $data->query->addOrderBy($this->sort);

        if (Yii::$app->getRequest()->isAjax) {
            Yii::$app->getResponse()->format = Response::FORMAT_JSON;

            return $this->controller->renderPartial($this->view, [
                        'model' => $data->getModels(),
            ]);
        } else {
 

            return $this->controller->render($this->view, [
                        'models' => $data->getModels(),
                        'pages' => $data->getPagination(),
            ]);
        }
    }

}
