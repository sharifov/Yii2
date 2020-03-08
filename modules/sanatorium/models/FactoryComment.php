<?php

namespace thread\modules\sanatorium\models;

use Yii;

class FactoryComment
{

    /**
     *   Создать комментарий
     *   @return Comment
     */
    public static function addComment($params) {

        $commentModel = new Comment();
        $commentModel->setScenario('backend');
        $commentModel->published = '1';
        $commentModel->load($params);

        if ( ! $commentModel->save()) {
            return $commentModel->getErrors();
        }

        $totalModel = self::getTotalModel($commentModel->sanatorium_id);
        $totalModel->addComments($commentModel);

        return $commentModel;
    }

    /**
     *  Update total for current comment
     * @param $model
     * @return TotalComment
     */
    public static function updateTotal($model)
    {
        $totalModel = self::getTotalModel($model->sanatorium_id);
        $totalModel->addComments($model);
        
        return $totalModel;
    }

    /**
     *   Скрыть но не удалять ( в корзину )
     *   @return Comment
     */
    public static function inTrash(Comment $comment) {

        $totalModel = self::getTotalModel($comment->sanatorium_id);
        $totalModel->delComments($comment);

        $comment->setScenario('deleted');
        $comment->deleted = 1;
        $comment->save();
        return $comment->save();
    }



    /**
     *   Скрыть но не удалять ( в корзину )
     *   @return Comment
     */
    public static function published(Comment $comment) {

        $totalModel = self::getTotalModel($comment->sanatorium_id);

        if ($comment->published == '1') {
            $totalModel->delComments($comment);
            $comment->published = '0';
        } else {
            $totalModel->addComments($comment);
            $comment->published = '1';
        }

        $comment->setScenario('published');
        $comment->save();
        return $comment->save();
    }


    /**
     *   Из корзины
     *   @return Comment
     */
    public static function outTrash(Comment $comment) {

        $totalModel = self::getTotalModel($comment->sanatorium_id);
        $totalModel->addComments($comment);

        $comment->setScenario('deleted');
        $comment->deleted = 0;
        $comment->save();

        return $comment->save();
    }

    /**
     *   Удалить комментарий
     *   @return boolean
     */

    public static function delComment(Comment $comment) {

        $totalModel = self::getTotalModel($comment->sanatorium_id);
        $totalModel->delComments($comment);
        return $comment->delete();
    }


    private static function getTotalModel($sanatorium_id)
    {
        $totalModel = TotalComment::find_base()->where(['sanatorium_id' => $sanatorium_id])->one();
        if (! $totalModel ) {
            $totalModel = new TotalComment;
        }

        return $totalModel;
    }


}
