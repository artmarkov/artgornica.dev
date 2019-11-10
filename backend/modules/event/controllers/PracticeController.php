<?php

namespace backend\modules\event\controllers;

use Yii;
use backend\controllers\DefaultController;

/**
 * PracticeController implements the CRUD actions for backend\modules\event\models\EventPractice model.
 */
class PracticeController extends DefaultController 
{
    public $modelClass       = 'backend\modules\event\models\EventPractice';
    public $modelSearchClass = 'backend\modules\event\models\search\EventPracticeSearch';

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
}