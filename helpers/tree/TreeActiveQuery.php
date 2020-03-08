<?php

namespace thread\helpers\tree;

/**
 * Class TreeActiveQuery
 * Trait для ActiveQuery [[TreeActiveQuery]]
 * 
 * @package thread\helpers\tree
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c) 2015, Thread
 */
trait TreeActiveQuery {

    /**
     * @return ActiveQuery $this
     */
    public function tree($tree) {
        $modelClass = $this->modelClass;
        $this->andWhere($modelClass::tableName() . '.tree = :tree', [':tree' => $tree]);
        return $this;
    }

    /**
     * @return ActiveQuery $this
     */
    public function _parent($parent) {
        $modelClass = $this->modelClass;
        $this->andWhere($modelClass::tableName() . '.parent = :parent', [':parent' => $parent]);
        return $this;
    }

    /**
     * @return ActiveQuery $this
     */
    public function level($level) {
        $modelClass = $this->modelClass;
        $this->andWhere($modelClass::tableName() . '.level = :level', [':level' => $level]);
        return $this;
    }

    /**
     * @return ActiveQuery $this
     */
    public function full_alias($full_alias) {
        $modelClass = $this->modelClass;
        $this->andWhere($modelClass::tableName() . '.full_alias = :full_alias', [':full_alias' => $full_alias]);
        return $this;
    }

}
