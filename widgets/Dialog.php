<?php

namespace thread\widgets;

use Yii;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;

/**
 * Class Dialog
 * Common-dialog для виклику діалогового вікна [[Dialog]]
 * 
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c) 2015, Thread
 * 
  echo \thread\widgets\Dialog::widget([
  'settings' => ['source' => \yii\helpers\Url::toRoute(['/menu/item/getitem', 'group' => $model->id])],
  ]);
 * 
 */
final class Dialog extends \yii\base\Widget {

    /**
     * Налаштування користувача
     * @var array
     */
    public $settings = [];

    /**
     * Мова інтерфейсу плагіну 
     * @var string 
     */
    public $language;

    /**
     * Параметри плагіну за-замовчуванням 
     * @var array 
     */
    private $_defaultSettings = [];

    /**
     * Initializes the widget.
     */
    public function init() {
        parent::init();

        $this->getDefaultSetting();

        if (empty($this->language))
            $this->language = Yii::$app->language;

        $this->settings = ArrayHelper::merge($this->_defaultSettings, $this->settings);
    }

    /**
     * Renders the widget.
     */
    public function run() {
        echo $this->getShowButton();
        ?>
        <!-- Modal -->
        <div class="modal fade" id="<?= $this->getId(); ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <?= $this->getHeader(); ?>
                    <div class="modal-body">
                        <?= $this->settings['content']; ?>
                    </div>
                    <?= $this->getFooter(); ?>
                </div>
            </div>
        </div>
        <?php
        $this->events();
    }

    /**
     * 
     * @return string
     */
    protected function getShowButton() {
        $r = '';
        if ($this->settings['button-show']['show'] === true):
            $r .= Html::button($this->settings['button-show']['title'], [
                        'class' => 'btn btn-primary',
                        'data-toggle' => 'modal',
                        'data-target' => '#' . $this->getId(),
            ]);
        endif;
        return $r;
    }

    /**
     * 
     * @return string
     */
    protected function getHeader() {
        $r = '';
        if ($this->settings['header']['show'] === true):
            $r .= Html::beginTag('div', ['class' => 'modal-header']);
            if ($this->settings['header']['button-close-show'] === true) {
                $r .= Html::beginTag('button', ['class' => 'close', 'type' => 'button', 'data-dismiss' => 'modal']);
                $r .= Html::tag('span', '&times;', ['aria-hidden' => 'true']);
                $r .= Html::tag('span', Yii::t('app', 'close'), ['class' => 'sr-only']);
                $r .= Html::endTag('button');
            }
            $r .= Html::tag('h4', $this->settings['header']['title'], ['class' => 'modal-title']);
            $r .= Html::endTag('div');
        endif;
        return $r;
    }

    /**
     * 
     * @return string
     */
    protected function getFooter() {
        $r = '';
        if ($this->settings['footer']['show'] === true):
            $r .= Html::beginTag('div', ['class' => 'modal-footer']);
            if ($this->settings['footer']['button-close']['show'] === true)
                $r .= Html::button($this->settings['footer']['button-close']['title'], [
                            'class' => 'btn btn-default',
                            'data-dismiss' => 'modal',
                ]);
            if ($this->settings['footer']['button-save']['show'] === true)
                $r .= Html::button($this->settings['footer']['button-save']['title'], [
                            'class' => 'btn btn-primary',
                ]);
            ?>
            <?php
            $r .= Html::endTag('div');
        endif;

        return $r;
    }

    /**
     * 
     */
    protected function getDefaultSetting() {
        $this->_defaultSettings = [
            'button-show' => [
                'show' => true,
                'title' => 'modal show',
            ],
            'header' => [
                'show' => true,
                'title' => Yii::t('app', 'title'),
                'button-close-show' => true,
            ],
            'content' => '...',
            'source' => '',
            'footer' => [
                'show' => true,
                'button-close' => [
                    'show' => true,
                    'title' => Yii::t('app', 'close'),
                ],
                'button-save' => [
                    'show' => true,
                    'title' => Yii::t('app', 'save'),
                ],
            ]
        ];
    }

    /**
     * 
     */
    protected function events() {
        $view = $this->getView();
        \yii\web\AssetBundle::register($view);
        $view->registerJs("
$('#" . $this->getId() . "').on('show.bs.modal', function (e) {
    $.post('" . $this->settings['source'] . "', function(data){
        $('#" . $this->getId() . "').find('.modal-body').html(data);
        console.log(data);
        });
});
$('#" . $this->getId() . "').on('hide.bs.modal', function (e) {
    $('#" . $this->getId() . "').find('.modal-body').html();
 });
        ", $view::POS_END);
    }

}
