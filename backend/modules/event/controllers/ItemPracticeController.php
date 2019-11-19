<?php

namespace backend\modules\event\controllers;

use Yii;
use backend\controllers\DefaultController;
use backend\modules\event\models\EventItemPractice;
use himiklab\sortablegrid\SortableGridAction;

/**
 * EventItemPracticeController implements the CRUD actions for backend\modules\event\models\EventItemPractice model.
 */
class ItemPracticeController extends DefaultController 
{
    public $modelClass       = 'backend\modules\event\models\EventItemPractice';
    public $modelSearchClass = '';
    
    /**
     * Вызывается методом Ajax из itemPractice.php
     */
    public function actionCreatePractice()
    {
        if (Yii::$app->request->post())
        {
            $id = Yii::$app->request->post('id');
            $practice_list = Yii::$app->request->post('practice_list');

            // echo '<pre>' . print_r($practice_list, true) . '</pre>';
            foreach ($practice_list as $practice_id)
            {
                $model = new EventItemPractice();
                $model->item_id = $id;
                $model->practice_id = $practice_id;
                if ($model->validate())
                {
                    $model->save();
                }
            }
            Yii::$app->session->setFlash('success', Yii::t('art/event', 'Your practices have been added.'));
            return $this->redirect(Yii::$app->request->referrer);
        }
        else
        {
            throw new HttpException(404, 'Page not found');
        }
    }
  
    /**
     * @return bool|\yii\web\Response
     *
     */
    public function actionRemove() {
        $id = Yii::$app->request->post('id');        
        $model = EventItemPractice::findOne($id);
        if (empty($model)) return false;
        $model->delete();
        Yii::$app->session->setFlash('info', Yii::t('art', 'Your item has been deleted.'));
        return $this->redirect(Yii::$app->request->referrer); 
    }
    /**
     * action sort for himiklab\sortablegrid\SortableGridBehavior
     * @return type
     */
    public function actions()
    {
        return [
            'sort' => [
                'class' => SortableGridAction::className(),
                'modelName' => $this->modelClass,
            ],
        ];
    }
     
}