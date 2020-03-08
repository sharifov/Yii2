<?php

namespace thread\helpers\tree\multi;

/**
 * Class MultiTreeModelTrait
 * Trait для ActiveRecord [[MultiTreeModelTrait]]
 * 
 * @package thread\helpers\tree\multi
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c) 2015, Thread
 */
trait MultiTreeModelTrait {

    use \thread\helpers\tree\TreeModelBaseTrait;
    
    /**
     * @param integer $tree
     */
    public static function findTreeModel($tree = 0) {
        $models = static::find()->addOrderBy(['position' => SORT_ASC])->all();
        foreach ($models as $model) {
            //заповнюємо моделі
            static::$treeModelCache[$model->id] = $model;
        }
    }
}
