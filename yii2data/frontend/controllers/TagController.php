<?php

namespace frontend\controllers;

use backend\modules\post\models\Post;
use artsoft\post\models\Tag;
use Yii;
use yii\data\Pagination;
use yii\web\NotFoundHttpException;

/**
 * Site controller
 */
class TagController extends \artsoft\controllers\BaseController
{
    public $freeAccess = true;

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex($slug = 'index')
    {
        if (empty($slug) || $slug == 'index') {
            throw new NotFoundHttpException('Page not found.');
        } else {
            $tag = Tag::find()->where(['slug' => $slug]);
            $tagCount = clone $tag;
            if (!$tagCount->count()) {
                throw new NotFoundHttpException('Page not found.');
            }
        }

        $query = Post::find()->joinWith('tags')->where([
            'status' => Post::STATUS_PUBLISHED,
            Tag::tableName() . '.slug' => $slug,
        ])->orderBy('published_at DESC');
        $countQuery = clone $query;

        $pagination = new Pagination([
            'totalCount' => $countQuery->count(),
            'defaultPageSize' => Yii::$app->settings->get('reading.page_size', 10),
        ]);

        $posts = $query->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();

        return $this->render('index', [
                'posts' => $posts,
                'tag' => $tag->one(),
                'pagination' => $pagination,
        ]);
    }
}