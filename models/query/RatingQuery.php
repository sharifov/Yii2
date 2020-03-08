<?php

namespace thread\models\query;

/**
 * Class RatingQuery
 *
 * @package thread\models\query;
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c) 2015, Thread
 */
class RatingQuery extends ActiveQuery {

    /**
     * Запис з встановленим полем user_id
     * @param integer $user_id
     * @return ActiveQuery $this
     */
    public function user_id($user_id) {
        $modelClass = $this->modelClass;

        $this->andWhere($modelClass::tableName() . '.user_id = :user_id', [':user_id' => $user_id]);

        return $this;
    }

    /**
     * Запис з встановленим полем item_id
     * @param integer $item_id
     * @return ActiveQuery $this
     */
    public function item_id($item_id) {
        $modelClass = $this->modelClass;

        $this->andWhere($modelClass::tableName() . '.item_id = :item_id', [':item_id' => $item_id]);

        return $this;
    }

}
