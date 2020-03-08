<?php

namespace thread\widgets\form\select2;

use Yii;
use yii\widgets\InputWidget;
use yii\helpers\Json;
use yii\helpers\Html;

/**
 * Select2 widget
 * Створено на базі {@link http://ivaynberg.github.io/select2/ Select2}.
 * @package thread\widgets\form\select2
 * @author Filament
 * @copyright (c) 2015, Thread
 * @version 07/02/2015
 * 
  <?= $form->field($model, 'field')->widget(Select2::class, [
    'options' => [
        'multiple' => true,
        'placeholder' => 'Choose item'
    ],
    'settings' => [
        'width' => '100%',
    ],
    'items' => [
        'item1',
        'item2',
        ...
    ]
  ]);
  ?>
 * 
 */
class Select2 extends InputWidget {

    /**
     * @var array {@link http://ivaynberg.github.io/select2/#documentation Select2} settings
     */
    public $settings = [];

    /**
     * @var array Select items
     */
    public $items = [];

    /**
     * @var string Plugin language. If `null`, [[\yii\base\Application::language|app language]] will be used.
     */
    public $language;

    /**
     * @var boolean Whatever to use bootstrap CSS or not.
     */
    public $bootstrap = false;

    /**
     * @inheritdoc
     */
    public function init() {
//        $this->options['id'] = $this->getId();
        parent::init();

        // Set language
        if ($this->language === null && ($language = Yii::$app->language) !== 'en-US') {
            $this->language = substr($language, 0, 2);
        }
    }

    public function run() {
        $this->registerClientScript();
        if ($this->hasModel()) {
            return Html::activeTextInput($this->model, $this->attribute, $this->options);
        } else {
            return Html::textInput($this->name, $this->value, $this->options);
        }
    }

    public function registerClientScript() {
        $view = $this->getView();
        $selector = '#' . $this->options['id'];
        $settings = Json::encode($this->settings);

        // Register asset
        $asset = Asset::register($view);

        if ($this->language !== null) {
            $asset->language = $this->language;
        }

        if ($this->bootstrap === true) {
            BootstrapAsset::register($view);
        } else {
            Select2Asset::register($view);
        }

        // Init widget
        $view->registerJs("jQuery('$selector').select2($settings);");
    }

}
