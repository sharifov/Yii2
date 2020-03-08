<?php

namespace thread\modules\user\models;

use Yii;

/**
 * Class SigInForm
 *
 * @package thread\modules\user\models
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c) 2015, Thread
 */
class SigInForm extends CommonForm {

    const FLASH_KEY = 'SigInForm';

    public $ONLY_ADMIN = false;

    /**
     *
     * @return boolean
     */
    public function login() {
        if ($this->validate()) {
            $user = $this->getUser();
            if ($user !== null && $this->ONLY_ADMIN === true) {
                if ($user['group_id'] != Group::ADMIN) {
                    $this->addFlash(Yii::t('user', 'user access is prohibited'));
                    return false;
                }
            }
            
            if ($user !== null) {
                if ($user['group_id'] == Group::ADMIN_SANATORIUM && $user['sanatorium_id'] == 0) {
                    $this->addFlash(Yii::t('app', 'Incorrect sanatorium/company information. Please, contact Administration!'));
                    return false;
                } elseif ($user['group_id'] == Group::WORKER_SANATORIUM && $user['sanatorium_id'] == 0) {
                    $this->addFlash(Yii::t('app', 'Incorrect sanatorium/company information. Please, contact Administration!'));
                    return false;
                } elseif ($user['group_id'] == Group::ADMIN_COMPANY && $user['company_id'] == 0) {
                    $this->addFlash(Yii::t('app', 'Incorrect sanatorium/company information. Please, contact Administration!'));
                    return false;
                }
            }

            return Yii::$app->getUser()->login($user, $this->rememberMe ? $this->getTimeRememberUserSigin() : 0);
        } else {
            return false;
        }
    }

}
