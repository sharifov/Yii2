<?php

namespace thread\widgets\form\upload;

use yii\base\Action;
use yii\base\InvalidConfigException;
use yii\helpers\FileHelper;
use Yii;

class DeleteAction extends Action
{
    /**
     * @var string Path to directory where files has been uploaded
     */
    public $path;

    /**
     * @var string Variable's name that FileAPI sent upon image/file upload.
     */
    public $uploadParam = 'file';

    /**
     * @inheritdoc
     */
    public function init()
    {
        if ($this->path === null) {
            throw new InvalidConfigException("Empty \"{$this->path}\".");
        } else {
            $this->path = FileHelper::normalizePath($this->path) . DIRECTORY_SEPARATOR;
        }
    }

    /**
     * @inheritdoc
     */
    public function run()
    {
        echo $this->path.Yii::$app->getRequest()->get($this->uploadParam);
        if (($file = Yii::$app->getRequest()->get($this->uploadParam))) {
            if (is_file($this->path . $file)) {
                echo 12;
                unlink($this->path . $file);
            }
        }
    }
}