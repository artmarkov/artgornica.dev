<?php

namespace backend\modules\event\controllers;

use Yii;
use backend\controllers\DefaultController;

/**
 * VidController implements the CRUD actions for backend\modules\event\models\EventVid model.
 */
class VidController extends DefaultController 
{
    public $modelClass       = 'backend\modules\event\models\EventVid';
    public $modelSearchClass = 'backend\modules\event\models\search\EventVidSearch';

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
     * Deletes an existing model.
     * 
     * @param integer $id
     *
     * @return mixed
     */
    public function actionDelete($id)
    {
        /* @var $model \artsoft\db\ActiveRecord */
        $model = $this->findModel($id);
        if($model->delete()) {
             Yii::$app->session->setFlash('info', Yii::t('art', 'Your item has been deleted.'));
        }
       
        return $this->redirect($this->getRedirectPage('delete', $model));
       
    }
}