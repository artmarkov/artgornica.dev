<?php

namespace frontend\controllers;

use frontend\actions\PageAction;
use frontend\actions\PostAction;
use common\models\Contact;
use artsoft\page\models\Page;
use backend\modules\post\models\Post;
use Yii;
use yii\data\Pagination;
use yii\web\NotFoundHttpException;
use backend\modules\event\models\EventSchedule;
use artsoft\parallax\models\Parallax;
use artsoft\carousel\models\Carousel;
use yii\data\ArrayDataProvider;
/**
 * Site controller
 */
class SiteController extends \artsoft\controllers\BaseController
{
    public $freeAccess = true;

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => '\frontend\components\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        $queryPost = Post::find()->where(
                [
                    'status' => Post::STATUS_PUBLISHED, 
                    'main_flag' => Post::MAIN_ON
                ]);
        $countQuery = clone $queryPost;
        
        if($countQuery->count() < Post::COUNT_POST_INDEX) {
        $posts = Post::find()->where(['status' => Post::STATUS_PUBLISHED])
                ->orderBy('published_at DESC')
                ->limit(Post::COUNT_POST_INDEX)
                ->all();
        }
        else {
        $posts = $queryPost->orderBy('published_at DESC')
                ->limit(Post::COUNT_POST_INDEX)
                ->all();
        }
        
         $parallax = Parallax::find()
                ->where(['status' => Parallax::STATUS_ACTIVE])
                ->one();
         
         
         $query = Carousel::find()
                ->where(['slug' => 'karousel-main'])
                ->andWhere(['status' => Carousel::STATUS_ACTIVE])->one();
         // echo '<pre>' . print_r($query, true) . '</pre>';
         if(!empty($query)) {
          $carousel = \yii\helpers\ArrayHelper::toArray($query);
          $carousel['model_name'] = $query->className();
         }
         else {
         $carousel['model_name'] = NULL;
         }
        return $this->render('index', [
                'posts' => $posts,
                'parallax' => $parallax,
                'carousel' => $carousel,
            ]);
    }

    /**
     * Displays blog
     *
     * @return mixed
     */
    public function actionBlog($slug = 'blog')
    {
        // display home page
        if (empty($slug) || $slug == 'blog') {

            $query = Post::find()->where(['status' => Post::STATUS_PUBLISHED]);
            $countQuery = clone $query;

            $pagination = new Pagination([
                'totalCount' => $countQuery->count(),
                'defaultPageSize' => Yii::$app->settings->get('reading.page_size', 10),
            ]);

            $posts = $query->orderBy('published_at DESC')->offset($pagination->offset)
                ->limit($pagination->limit)
                ->all();

            return $this->render('blog-masonry', [
                'posts' => $posts,
                'pagination' => $pagination,
            ]);
        }

        //try to display action from controller
        try {
            return $this->runAction($slug);
        } catch (\yii\base\InvalidRouteException $ex) {

        }

        //try to display static page from datebase
        $page = Page::getDb()->cache(function ($db) use ($slug) {
            return Page::findOne(['slug' => $slug, 'status' => Page::STATUS_PUBLISHED]);
        }, 3);//3600

        if ($page) {
            $pageAction = new PageAction($slug, $this, [
                'slug'   => $slug,
                'page'   => $page,
                'view'   => $page->view,
                'layout' => $page->layout,
            ]);

            return $pageAction->run();
        }

        //try to display post from datebase
        $post = Post::getDb()->cache(function ($db) use ($slug) {
            return Post::findOne(['slug' => $slug, 'status' => Post::STATUS_PUBLISHED]);
        }, 3);//3600

        if ($post) {
            $postAction = new PostAction($slug, $this, [
                'slug'   => $slug,
                'post'   => $post,
                'view'   => $post->view,
                'layout' => $post->layout,
            ]);

            return $postAction->run();
        }

        //if nothing suitable was found then throw 404 error
        throw new \yii\web\NotFoundHttpException('Page not found.');
    }

    /**
     * Displays contact page.
     *
     * @return mixed
     */
    public function actionContact()
    {
        $model = new Contact();
        
        $model->scenario = 'contact';
        
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
           if ($model->sendEmail(Yii::$app->settings->get('general.email'))) {
                Yii::$app->session->setFlash('success', '<i class="fa fa-check-circle"></i>' . Yii::t('art','Thank you for contacting us. We will respond to you as soon as possible.'));
            } else {
                Yii::$app->session->setFlash('error', '<i class="fa fa-frown-o"></i>' . Yii::t('art','Thank you for contacting us. We will respond to you as soon as possible.'));
            }           
            $model->save();            
            return $this->refresh();
        } else {
            return $this->render('contact', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Displays about page.
     *
     * @return mixed
     */
    public function actionAbout()
    {
         $query = Carousel::find()
                ->where(['slug' => 'karousel-about'])
                ->andWhere(['status' => Carousel::STATUS_ACTIVE])->one();
         
          if(!empty($query)) {
          $carousel = \yii\helpers\ArrayHelper::toArray($query);
          $carousel['model_name'] = $query->className();
         }
         else {
         $carousel['model_name'] = NULL;
         }
          
         
        return $this->render('about', [
                'carousel' => $carousel,
            ]);
    }
    /**
     * 
     * @return render
     */
    public function actionPortfolio()
    {
                 
        return $this->render('portfolio');
    }
    
    /**
     * Displays about page.
     *
     * @return mixed
     */
//    public function actionPrivate()
//    {
//        
////         if($this->module->profileLayout){
////            $this->layout = $this->module->profileLayout;
////        }
//                
//        
//          if (Yii::$app->user->isGuest) {
//            throw new NotFoundHttpException(Yii::t('yii', 'Page not found.'));
//        }
//
//        $query = EventSchedule::find()
//                ->innerJoin('event_schedule_users', 'event_schedule_users.schedule_id = event_schedule.id')
//                ->where(['event_schedule_users.user_id' => Yii::$app->user->id]);
//
//        $pagination = new Pagination([
//            'totalCount' => $query->count(), 
//            'defaultPageSize' => Yii::$app->settings->get('reading.page_size', 10)
//            ]);
//        $model = $query->orderBy('start_timestamp DESC')->offset($pagination->offset)
//                ->limit($pagination->limit)
//                ->all();
//                //echo '<pre>' . print_r($model, true) . '</pre>';
//       
//        $model_profile = \artsoft\models\User::findIdentity(Yii::$app->user->id);
//
//        if ($model_profile->load(Yii::$app->request->post()) AND $model_profile->save()) {
//            Yii::$app->session->setFlash('success', Yii::t('art', 'Your item has been updated.'));
//        }
//
//        return $this->renderIsAjax('private', compact('model_profile', 'model', 'pagination'));
//        
//    }
    /**
     * 
     * @param type $q
     * @return type
     */
    public function actionSearch() {
        $q = Yii::$app->request->get('q');
        
        if (strlen($q) > 2) {
            
            $searchData = Yii::$app->get('searcher')->search($q);

            $dataProvider = new ArrayDataProvider([
                'allModels' => $searchData,
                'pagination' => [
                    'pageSize' => Yii::$app->settings->get('reading.page_size', 10)
                ],
            ]);
            $rows = $dataProvider->getModels();
            // echo '<pre>' . print_r($rows, true) . '</pre>';
            return $this->render(
                            'found', [
                                'hits' => $rows,
                                'pagination' => $dataProvider->getPagination(),
                                'query' => $q
                             ]
            );
        } else {
            
            Yii::$app->session->setFlash('warning', Yii::t('art', 'Для запроса введите не менее 3-х символов.'));
            return $this->redirect(Yii::$app->request->referrer);
        }
    }

}
