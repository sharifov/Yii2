<?php

/**
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c) 2015, Thread
 */
return [
    //themes base settings
    'themes' => [
        'language' => 'ru-RU',
        'languages' => [
            'en-EN' => 'English',
            'ru-RU' => 'Русский',
//            'uk-UA' => 'Українська',
        ]
    ],
    //editor base settings
    'allowHtmlTags' => 'p,span,strong,ul,ol,li,em,u,strike,br,hr,img,a',
    //file system base setting
    'uploadFolder' => Yii::getAlias('@commonFolder') . '/frontend/upload',
];
