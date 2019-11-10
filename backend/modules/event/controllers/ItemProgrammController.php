<?php

namespace backend\modules\event\controllers;

use Yii;
use backend\controllers\DefaultController;
use backend\modules\event\models\EventItemProgramm;
use himiklab\sortablegrid\SortableGridAction;

/**
 * EventItemProgrammController implements the CRUD actions for backend\modules\event\models\EventItemProgramm model.
 */
class ItemProgrammController extends DefaultController 
{
    public $modelClass       = 'backend\modules\event\models\EventItemProgramm';
    public $modelSearchClass = '';

    protected function getRedirectPage($action, $model = null)
    {
        switch ($action) {
            case 'update':
                return ['update', 'id' => $model->id];
                break;
            case 'create':
                return ['update', 'id' => $model->id];
                break;
            default:
                return parent::getRedirectPage($action, $model);
        }
    }
    
    /**
     * Вызывается методом Ajax из itemProgramm.php
     */
    public function actionInitProgramm()
    {
        $id = Yii::$app->request->get('id');
        $item_id = Yii::$app->request->get('item_id');
        if(empty($item_id)) return false;
        $model = new EventItemProgramm();
        
        //echo '<pre>' . print_r($modelUser, true) . '</pre>';

        if (!Yii::$app->request->isAjax) {
            return $this->redirect(Yii::$app->request->referrer);
        }
        $model->programm_id = $id;
        $model->item_id = $item_id;

        $this->layout = false;
        return $this->renderIsAjax('item-programm-modal',  ['model' => $model]);
    }

    /**
     * @return array|\yii\web\Response
     * @throws HttpException
     */
    public function actionCreateProgramm() {

        $model = new EventItemProgramm();

        if ($model->load(Yii::$app->request->post())) {

            // echo '<pre>' . print_r($model, true) . '</pre>';

            if ($model->load(Yii::$app->request->post()) && Yii::$app->request->isAjax) {
                \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

                return \yii\widgets\ActiveForm::validate($model);
            } elseif ($model->load(Yii::$app->request->post())) {
                
                if ($model->save()) {
                    Yii::$app->session->setFlash('crudMessage', Yii::t('art', 'Your item has been created.'));
                    return $this->redirect(Yii::$app->request->referrer);
                }
            }
        } else {
            throw new HttpException(404, 'Page not found');
        }
    }

    /**
     * @return array|bool|string|\yii\web\Response
     */
    public function actionUpdateProgramm() {

        $id = Yii::$app->request->get('id');

        $model = EventItemProgramm::findOne($id);
        if(empty($model)) return false;

            // echo '<pre>' . print_r($model, true) . '</pre>';

        if ($model->load(Yii::$app->request->post()) && Yii::$app->request->isAjax) {
            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

            return \yii\widgets\ActiveForm::validate($model);
        } elseif ($model->load(Yii::$app->request->post())) {
            
            if ($model->save()) {
                Yii::$app->session->setFlash('crudMessage', Yii::t('art', 'Your item has been updated.'));
                return $this->redirect(Yii::$app->request->referrer);
            }

    } else {
        $this->layout = false;
        return $this->renderIsAjax('item-programm-modal',  ['model' => $model]);
    }
}

    /**
     * @return bool|\yii\web\Response
     *
     */
    public function actionRemove() {
        $id = Yii::$app->request->get('id');        
        $model = EventItemProgramm::findOne($id);
        if (empty($model)) return false;
        $model->delete();
        Yii::$app->session->setFlash('crudMessage', Yii::t('art', 'Your item has been deleted.'));
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