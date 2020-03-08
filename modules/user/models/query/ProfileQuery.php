<?php

namespace thread\modules\user\models\query;

/**
 * Class ProfileQuery
 *
 * @package thread\modules\user\models\query
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c) 2015, Thread
 */
class ProfileQuery extends \thread\models\query\ActiveQuery {

    /**
     *
     * @param string $user_id
     * @return \thread\modules\user\models\query\UserQuery
     */
    public function user_id($user_id) {
        $modelClass = $this->modelClass;
        $this->andWhere($modelClass::tableName() . '.user_id = :user_id', [':user_id' => $user_id]);
        return $this;
    }

}
