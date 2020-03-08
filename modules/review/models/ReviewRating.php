<?php

namespace thread\modules\review\models;

use thread\models\RatingRecord;

/**
 * Class ReviewRating
 *
 * @package thread\modules\review\models
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c) 2015, Thread
 */
class ReviewRating extends RatingRecord {

    protected static $obj = Review;

    /**
     * 
     * @return string
     */
    public static function getDb() {
        return \thread\modules\review\Review::getDb();
    }

    /**
     * 
     * @return string
     */
    public static function tableName() {
        return '{{%review_rate}}';
    }

}
