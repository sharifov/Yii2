<?php

namespace thread\modules\review\models\query;

/**
 * Class ReviewQuery
 *
 * @package thread\modules\review\models\query
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c) 2015, Thread
 */
class ReviewQuery extends \thread\models\query\ActiveQuery {

    /**
     * Записи за полем item_id
     * 
     * @param integer $item_id
     * @return \thread\modules\review\models\query\ReviewQuery
     */
    public function item_id($item_id) {
        $modelClass = $this->modelClass;
        $this->andWhere($modelClass::tableName() . '.item_id = :item_id', [':item_id' => $item_id]);
        return $this;
    }

    /**
     * Записи за полем user_id
     * 
     * @param integer $user_id
     * @return \thread\modules\review\models\query\ReviewQuery
     */
    public function user_id($user_id) {
        $modelClass = $this->modelClass;
        $this->andWhere($modelClass::tableName() . '.user_id = :user_id', [':user_id' => $user_id]);
        return $this;
    }

}
