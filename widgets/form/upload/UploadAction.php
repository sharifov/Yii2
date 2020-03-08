<?php

namespace thread\widgets\form\upload;

use Yii;
use yii\base\Action;
use yii\base\DynamicModel;
use yii\base\InvalidCallException;
use yii\base\InvalidConfigException;
use yii\helpers\FileHelper;
use yii\web\BadRequestHttpException;
use yii\web\Response;
use yii\web\UploadedFile;

/**
 * для тестів
 */
class UploadAction extends Action {

    /**
     * @var string Path to directory where files will be uploaded
     */
    public $path;

    /**
     * @var string Validator name
     */
    public $uploadOnlyImage = true;

    /**
     * @var string The parameter name for the file form data (the request argument name).
     */
    public $paramName = 'file';

    /**
     * @var boolean If `true` unique filename will be generated automatically
     */
    public $unique = true;

    /**
     * @var array Model validator options
     */
    public $validatorOptions = [];

    /**
     * @var string Model validator name
     */
    private $_validator = 'image';

    /**
     * @inheritdoc
     */
    public function init() {
        if ($this->path === null) {
            throw new InvalidConfigException('The "path" attribute must be set.');
        } else {
            $this->path = FileHelper::normalizePath(Yii::getAlias($this->path)) . DIRECTORY_SEPARATOR;

            if (!FileHelper::createDirectory($this->path)) {
                throw new InvalidCallException("Directory specified in 'path' attribute doesn't exist or cannot be created.");
            }
        }
        if ($this->uploadOnlyImage !== true) {
            $this->_validator = 'file';
        }
    }

    /**
     * @inheritdoc
     */
    public function run() {
        if (Yii::$app->request->isPost) {

            $response = [];

            $files = UploadedFile::getInstancesByName($this->paramName);

            foreach ($files as $file) {
                $model = new DynamicModel(compact('file'));
                $model->addRule('file', $this->_validator, $this->validatorOptions)->validate();
                if ($this->unique === true && $model->file->extension) {
                    $model->file->name = uniqid() . '.' . $model->file->extension;
                    $model->file->saveAs($this->path . $model->file->name);
                    $response[] = $model->file->name;
                }
            }

            Yii::$app->response->format = Response::FORMAT_JSON;

            return implode(',', $response);
        } else {
            throw new BadRequestHttpException('Only POST is allowed');
        }
    }

}
