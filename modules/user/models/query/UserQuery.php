<?php

namespace thread\modules\user\models\query;

/**
 * Class UserQuery
 *
 * @package thread\modules\user\models\query
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c) 2015, Thread
 */
class UserQuery extends \thread\models\query\ActiveQuery {

    /**
     *
     * @param string $username
     * @return \thread\modules\user\models\query\UserQuery
     */
    public function username($username) {
        $modelClass = $this->modelClass;
        $this->andWhere($modelClass::tableName() . '.username = :username', [':username' => $username]);
        return $this;
    }

    /**
     *
     * @param string $email
     * @return \thread\modules\user\models\query\UserQuery
     */
    public function email($email) {
        $modelClass = $this->modelClass;
        $this->andWhere($modelClass::tableName() . '.email = :email', [':email' => $email]);
        return $this;
    }

    /**
     *
     * @param string $token
     * @return \thread\modules\user\models\query\UserQuery
     */
    public function password_reset_token($token) {
        $modelClass = $this->modelClass;
        $this->andWhere($modelClass::tableName() . '.password_reset_token = :token', [':token' => $token]);
        return $this;
    }

}
