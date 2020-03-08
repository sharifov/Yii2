# Використання
# ActiveRecord

use thread\helpers\tree\multi\MultiTreeBehavior;

class ActiveRecord {

    use \thread\helpers\tree\multi\MultiTreeModelTrait;

    public function behaviors() {
        return ArrayHelper::merge(parent::behaviors(), [
...
                    'multitree' => [
                        'class' => MultiTreeBehavior::class,
                    ],
...
        ]);
    }

}

#ActiveQuery
class ActiveQuery {
    use \thread\helpers\tree\TreeActiveQuery;
}