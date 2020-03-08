<?php

namespace thread\widgets;

use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\JsExpression;

/**
 * Class ActiveForm
 *
 * @package thread\widgets
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c) 2015, Thread
 */
class ActiveForm extends \yii\widgets\ActiveForm {

    public $enableClientValidation = true;
    public $enableAjaxValidation = false;
    public $validateOnSubmit = true;
    public $enableClientScript = false;
    public $validationUrl = 'validation';

    public function init() {

        $this->action = (empty($this->action)) ? Url::current() : $this->action;

        parent::init();

        $this->validationUrl = Url::toRoute($this->validationUrl) . '?id=' . ((isset($_GET['id'])) ? $_GET['id'] : 0);
        $view = $this->getView();
        $view->registerJs($this->setSubmit());

//        echo Html::hiddenInput("language", Yii::$app->language);
    }

    public function setSubmit() {
        return new JsExpression('$("#' . $this->getId() . ' .sanatorium-red-button ").on( "click", function() {
            var t_btn=$(this);
            var formId = "#' . $this->getId() . '";
            var url = "' . $this->validationUrl . '";
            var is_valid = false;

            //form validation doesnt work

            t_btn.css("background","#ccc").css("border-color","#ccc").attr("disabled",true).html("Подождите... <i class=\'fa fa-spinner fa-spin\'></i></button>");
            $(formId).submit();
            return true;

            if(url.length){
                var dataForm = $(formId).serialize();

                $.post(url, dataForm, function(data){
                    var obj = data;
                    var classExtError = "-error";

                    //console.log(data.length);
                    $(formId).find(".error").html(" ");
                    $(formId).find(".has-error").removeClass("has-error");

                    if(data.length == 0){
                        is_valid = true;
                        t_btn.css("background","#ccc").css("border-color","#ccc").attr("disabled",true).html("Подождите... <i class=\'fa fa-spinner fa-spin\'></i></button>");
                         
                        $(formId).submit();
                    }

                    for(attr in obj){
                        $("#"+attr).parents(".row").addClass("has-error");
                        $("#"+attr+classExtError).html(obj[attr]);
                    }

                });

            }
             return false;
            //return is_valid;
        });');
    }

    /**
     *
     * @param type $models
     * @param type $attributes
     * @return array
     */
    public static function validateMultiple($models, $attributes = null) {
        $result = [];
        /** @var Model $model */
        foreach ($models as $model) {
            $model->validate($attributes);
            foreach ($model->getErrors() as $attribute => $errors)
                $result[Html::getInputId($model, $attribute)] = $errors;
        }

        return $result;
    }

}
