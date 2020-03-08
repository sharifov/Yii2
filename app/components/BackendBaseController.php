<?php

namespace thread\app\components;

use Yii;
use yii\helpers\Url;
use yii\filters\AccessControl;
use yii\web\Response;
use thread\widgets\ActiveForm;
use thread\actions\AttributeSwith;
use thread\actions\Delete as DeleteAction;
use thread\actions\CreateWithLang;
use thread\actions\UpdateWithLang;
use thread\actions\ListModel;

/**
 * Class BackendBaseController
 *
 * @package thread\app\components
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c) 2015, Thread
 */
abstract class BackendBaseController extends \yii\web\Controller
{
    /**
     * Назва контролера
     * @var string
     */
    public $title = "Base";

    /**
     * Мовне значення атрибута title
     * @var string
     */
    public $label = "";

    /**
     * Хлібні крихти
     * @var array ['label'=>'', url=>'']
     */
    public $breadcrumbs = [];

    /**
     * Базовий layout
     * @var string
     */
    public $layout = "@app/layouts/main";

    /**
     * action 'list' link status
     * @var string
     */
    public $actionListLinkStatus = "list";

    public function __construct($id, $module, $config = [])
    {
        parent::__construct($id, $module, $config);

        $this->label = Yii::t($this->module->name, $this->title);

        $this->breadcrumbs = [
            [
                'label' => Yii::t($this->module->name, $this->module->title),
                'url' => ['list'],
            ],
            [
                'label' => $this->label,
                'url' => ['list'],
            ],
        ];
    }

    /**
     *
     */
    public function init()
    {
        /**
         * Встановлення мови інрефейсу користувача
         */
        if (Yii::$app->getUser()->isGuest !== true) {
            Yii::$app->params['themes']['language'] = Yii::$app->getUser()->getIdentity()['profile']['preferred_language'];
        }

        return parent::init();
    }

    /**
     * Базові налаштування доступу до адміністративної частини
     * @return array
     */
    public function behaviors()
    {
        return [
            'AccessControl' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['error'],
                        'roles' => ['?', '@'],
                    ],
                    [
                        'allow' => true,
                        'roles' => ['admin'],
                    ],
                    [
                        'allow' => false,
                    ],
                ],
            ],
        ];
    }

    /**
     * Назва базового методу дії
     * @var string
     */
    public $defaultAction = 'list';

    /**
     * Назва базової моделі
     * @var string
     */
    protected $model = '';

    /**
     * Назва базової моделі мови
     * @var string
     */
    protected $modelLang = '';

    /**
     * Перелік підключених Дій
     * @return array
     */
    public function actions()
    {
        return [
            'list' => [
                'class' => ListModel::class,
                'modelClass' => $this->model,
            ],
            'trash' => [
                'class' => ListModel::class,
                'modelClass' => $this->model,
                'layout' => '@admin/layouts/trash',
                'methodName' => 'trash',
                'view' => 'trash'
            ],
            'create' => [
                'class' => CreateWithLang::class,
                'modelClass' => $this->model,
                'modelClassLang' => $this->modelLang,
                'redirect' => function () {
                    return ($_POST['save_and_exit']) ? $this->actionListLinkStatus : ['update', 'id' => $this->action->getModel()->id];
                }
            ],
            'update' => [
                'class' => UpdateWithLang::class,
                'modelClass' => $this->model,
                'modelClassLang' => $this->modelLang,
                'redirect' => function () {
                    return ($_POST['save_and_exit']) ? $this->actionListLinkStatus : ['update', 'id' => $this->action->getModel()->id];
                }
            ],
            'published' => [
                'class' => AttributeSwith::class,
                'modelClass' => $this->model,
                'attribute' => 'published',
                'redirect' => $this->defaultAction,
            ],
            'intrash' => [
                'class' => AttributeSwith::class,
                'modelClass' => $this->model,
                'attribute' => 'deleted',
                'redirect' => $this->defaultAction,
            ],
            'outtrash' => [
                'class' => AttributeSwith::class,
                'modelClass' => $this->model,
                'attribute' => 'deleted',
                'redirect' => $this->defaultAction,
            ],
            'delete' => [
                'class' => DeleteAction::class,
                'modelClass' => $this->model,
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function beforeAction($action)
    {
        $this->actionListLinkStatus = Yii::$app->getSession()->get($this->module->id . "_" . $this->id . "_list", 'list');

                    if (!Yii::$app->user->isGuest) {
               $value = Yii::$app->getRequest()->getCookies()->getValue('_identity');
                    $data = json_decode($value, true);
                    if ($data[1] != Yii::$app->user->identity->auth_key) {
                     return $this->redirect('/admin/user/logout');
                    }
            }

        return parent::beforeAction($action);
    }

    /**
     * @inheritdoc
     */
    public function afterAction($action, $result)
    {
        if ($this->action->id === 'list') {
            Yii::$app->getSession()->set($this->module->id . "_" . $this->id . "_list", Url::current());
        }
        return parent::afterAction($action, $result);
    }

    /**
     * Перевірка валідації моделі(-ей)
     * Має бути встановдений у моделі scenario 'backend'
     * @return json
     */
    public function actionValidation()
    {
        $models = [];
        $id = (isset($_GET['id'])) ? $_GET['id'] : 0;
        $model = ($id > 0) ? $this->findModel($id) : new $this->model;
        $model->setScenario('backend');
        $model->load(Yii::$app->getRequest()->post());
        $models[] = $model;

        $modelLang = (class_exists($this->modelLang)) ? ($id) ? $this->findModelLang($id) : new $this->modelLang : null;
        if ($modelLang !== null) {
            $modelLang = new $this->modelLang;
            $modelLang->setScenario('backend');
            $modelLang->load(Yii::$app->getRequest()->post());
            $modelLang->rid = $model->id;
            $modelLang->lang = Yii::$app->language;
            $models[] = $modelLang;
        }

        Yii::$app->getResponse()->format = Response::FORMAT_JSON;

        return ActiveForm::validateMultiple($models);
    }

    /**
     * Пошук моделі по первинному ключу
     * Якщо модель не знайдена, повертається null
     * @param integer|array $id Ідентифікатор моделі
     * @return {Model}|null Повернення знайденої моделі
     */
    protected function findModel($id)
    {
        $modelClass = $this->model;
        $keys = $modelClass::primaryKey();

        if (count($keys) > 1) {
            $values = explode(',', $id);
            if (count($keys) === count($values)) {
                $model = $modelClass::findOne(array_combine($keys, $values));
            }
        } elseif ($id !== null) {
            $model = $modelClass::findOne($id);
        }

        return $model;
    }

    /**
     * Пошук мовної моделі по первинному ключу
     * Якщо модель не знайдена, повертається null
     * @param integer $id Ідентифікатор моделі
     * @return {Model}Lang Повернення знайденої моделі
     */
    protected function findModelLang($id)
    {
        if (!(class_exists($this->modelLang))) {
            return null;
        }
        $m = new $this->modelLang;
        if ($id) {
            $model = $m->find()->andWhere(['rid' => $id])->one();
        }
        if ($model === null) {
            $model = $m->loadDefaultValues();
        }
        return $model;
    }

}
