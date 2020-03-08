<?php

namespace thread\helpers\tree\one;

use yii\base\Behavior;
use yii\helpers\ArrayHelper;
use yii\validators\Validator;
use yii\db\ActiveRecord;

/**
 * 
  //tree attribute
  [['position', 'level'], 'default', 'value' => 0],
  [['parent', 'position', 'level'], 'integer'],
  [['full_alias'], 'string', 'max' => 255],
  [['alias'], 'unique', 'targetAttribute' => ['level', 'parent']],
  [['full_alias'], 'unique'],
  [['parent'], 'validateParentPath'],
 *
 * Class TreeBehavior
 * Behavior для ActiveRecord [[TreeBehavior]]
 * 
 * @package thread\helpers\tree\multi
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c) 2015, Thread
 */
class TreeBehavior extends Behavior {

    /**
     * Якщо використовується атрибут full_alias
     * для зберігання повного символьного імені
     * @var boolean 
     */
    public $useFullAlias = true;

    public function attach($owner) {
        parent::attach($owner);
        $this->addRules();
    }

    public function events() {

        $r = [
            ActiveRecord::EVENT_BEFORE_INSERT => [$this->owner, 'validateLevel'],
            ActiveRecord::EVENT_BEFORE_UPDATE => [$this->owner, 'validateLevel'],
            ActiveRecord::EVENT_AFTER_UPDATE => [$this->owner, 'restructureSubTree']
        ];
        if ($this->useFullAlias === true) {
            $r = ArrayHelper::merge($r, [
                        ActiveRecord::EVENT_BEFORE_VALIDATE => [$this->owner, 'createFullAlias'],
            ]);
        }

        return $r;
    }

    protected function addRules() {

        $this->owner->validators[] = Validator::createValidator('default', $this->owner, ['position', 'level'], ['value' => 0]);
        $this->owner->validators[] = Validator::createValidator('integer', $this->owner, ['parent', 'position', 'level']);
        $this->owner->validators[] = Validator::createValidator('validateParentPath', $this->owner, ['parent']);
        $this->owner->validators[] = Validator::createValidator('required', $this->owner, ['alias']);
        $this->owner->validators[] = Validator::createValidator('string', $this->owner, ['alias'], ['max' => 255]);
        $this->owner->validators[] = Validator::createValidator('unique', $this->owner, ['alias'], ['targetAttribute' => ['alias', 'level', 'parent']]);

        if ($this->useFullAlias === true) {
            $this->owner->validators[] = Validator::createValidator('string', $this->owner, ['full_alias'], ['max' => 255]);
            $this->owner->validators[] = Validator::createValidator('unique', $this->owner, ['full_alias']);
            $this->owner->validators[] = Validator::createValidator('required', $this->owner, ['full_alias']);
        }
    }

}
