<?php

namespace thread\modules\user\models;

use thread\models\ActiveRecord;

/**
 * Class RegisterForm
 *
 * @package thread\modules\user\models
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c) 2015, Thread
 */
class RegisterForm extends CommonForm {

    /**
     * add new user to base
     */
    public function addUser() {

        $model = new User([
            'scenario' => 'usercreate',
            'username' => $this->username,
            'email' => $this->username,
            'published' => ActiveRecord::STATUS_KEY_ON,
            'group_id' => Group::USER,
        ]);
        $model->setPassword($this->password)->generateAuthKey();

        if ($model->validate()) {

            $transaction = self::getDb()->beginTransaction();

            try {
                $save = $model->save();
                ($save) ? $transaction->commit() : $transaction->rollBack();
            } catch (Exception $e) {
                $transaction->rollBack();
            }

            return $save;
        } else {
            $this->addErrors($model->getErrors());
            return false;
        }
    }

}
