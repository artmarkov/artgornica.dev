<?php

namespace backend\modules\event\controllers;

use Yii;
use backend\controllers\DefaultController;
use backend\modules\event\models\EventPlan;
use artsoft\fullcalendarscheduler\models\Event as BaseEvent;
use artsoft\fullcalendarscheduler\models\Resource;
use yii\helpers\ArrayHelper;
use yii\filters\VerbFilter;

/**
 * EventPlanController implements the CRUD actions for backend\modules\event\models\EventPlan model.
 */
class PlanController extends DefaultController 
{
    public $modelClass       = 'backend\modules\event\models\EventPlan';
    public $modelSearchClass = 'backend\modules\event\models\search\EventPlanSearch';

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
    public function behaviors()
    {
        return ArrayHelper::merge(parent::behaviors(), [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['refactor-event', 'remove-event'],
                ],
            ],
        ]);
    }
     /**
     * @return string|\yii\web\Response
     *
     * рендерим виджет календаря - планирование
     *
     */
    public function actionPlancalendar()
    {
        return $this->renderIsAjax('plancalendar');
    }
    
     /**
     * @return string|\yii\web\Response
     *
     * открывает модальное окно добавления события
     *
     */
    public function actionInitEvent()
    {

        $eventData = Yii::$app->request->post('eventData');
        $id = $eventData['id'];

        if ($id == 0) {
            $model = new EventPlan();
            $model->place_id = $eventData['resourceId'];
            
            Yii::$app->formatter->timeZone = 'UTC';
            $model->start_time = \Yii::$app->formatter->asDatetime($eventData['start']);
            $model->end_time = \Yii::$app->formatter->asDatetime($eventData['end']);
            
            return $this->renderAjax('plan-modal', [
                'model' => $model
            ]);

        } else {
            $model = EventPlan::findOne($id);
            return $this->renderAjax('plan-modal', [
                'model' => $model, 'id' => $id
            ]);
        }

    }
     /**
     * @param null $start
     * @param null $end
     *
     * формирует массив событий текущей страницы календаря
     *
     * @return array
     */
    public function actionCalendar()
    {

        $tasks = [];
        $delta = 86400*30;
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $start = Yii::$app->request->get('start');
        $end = Yii::$app->request->get('end');

        $start_timestamp = Yii::$app->formatter->asTimestamp($start);
        $end_timestamp = Yii::$app->formatter->asTimestamp($end);

        $events_plan = EventPlan::find()
                ->where(
                        "start_timestamp >= :start_timestamp and end_timestamp <= :end_timestamp", [
                    ":start_timestamp" => $start_timestamp - $delta,
                    ":end_timestamp" => $end_timestamp + $delta
                        ]
                )
                ->orderBy('start_timestamp')
                ->all();


        foreach ($events_plan as $item) {

            $event = new BaseEvent();
            $event->id = $item->id;
            $event->title = $item->programmName;
            if (!empty($item->place_id)) {
//                $event->resourceId = $item->place_id;
                $event->color = $item->placeColor;
            } else {
                $event->color = $item->color;
            }
//            $event->rendering = 'background'; // для фоновых событий
            $item->all_day == 1 ? $event->allDay = true : $event->allDay = false;
            $event->start = Yii::$app->formatter->asDatetime($item->start_timestamp,"php:Y.m.d H:i");
            $event->end = Yii::$app->formatter->asDatetime($item->end_timestamp,"php:Y.m.d H:i");
            
            $tasks[] = $event;
        }
//        echo '<pre>' . print_r($events_plan, true) . '</pre>';
       
        return $tasks;
    }
     public function actionResources()
    {

        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        
        $events = \backend\modules\event\models\EventPlace::find()->all();
        $tasks = [];
        foreach ($events as $item) {

            $resource = new Resource();
            $resource->id = $item->id;
            $resource->eventColor = $item->event_color; 
//            $resource->eventTextColor = $item->event_text_color;
            $resource->title = $item->name;
           
            $tasks[] = $resource;
        }
         //echo '<pre>' . print_r($tasks, true) . '</pre>';
         return $tasks;
    }

    /**
     * @return bool
     */
    public function actionUpdateEvent()
    {
        $eventData = Yii::$app->request->post('eventData');
       // echo '<pre>' . print_r($eventData, true) . '</pre>';       
        $id = $eventData['id'];

       $id == 0 ?  $model = new EventPlan() : $model = EventPlan::findOne($id);
                   
        $model->start_time = $eventData['start'];
        $model->end_time = $eventData['end'];
        
        if(!empty($eventData['allDay'])) $eventData['allDay'] == 'false' ? $model->all_day = 0 : $model->all_day = 1;
        
        if(!empty($eventData['resourceId']))  $model->place_id = $eventData['resourceId'];
        if(!empty($eventData['programmId']))  $model->programm_id = $eventData['programmId'];
//        if(!empty($eventData['itemProgrammId']))  $model->item_programm_id = $eventData['itemProgrammId'];
//        if(!empty($eventData['users']))       $model->users_list = $eventData['users'];
        if(!empty($eventData['description'])) $model->description = $eventData['description'];

        if($model->save()) {
            return true;
        }
        else {
            return false;
        }
    } 
    /**
     * @return bool
     */
    public function actionRefactorEvent()
    {
        $eventData = Yii::$app->request->post('eventData');
//        echo '<pre>' . print_r($eventData, true) . '</pre>';       
        $id = $eventData['id'];

        $model = EventPlan::findOne($id);
                   
        $model->start_time = $eventData['start'];
        $model->end_time = $eventData['end'];
        
        if(!empty($eventData['allDay'])) $eventData['allDay'] == 'false' ? $model->all_day = 0 : $model->all_day = 1;
        if(!empty($eventData['resourceId'])) $model->place_id = $eventData['resourceId'];
       

        if($model->save()) {
            return true;
        }
        else {
            return false;
        }
    }
    /**
     * @return bool
     */
    public function actionRemoveEvent()
    {
        $id = Yii::$app->request->post('id');

        $model = EventPlan::findOne($id);
        // echo '<pre>' . print_r($model, true) . '</pre>';
        if ($model) {
            $model->delete();
            return true;
        } else {
            return false;
        }
    }
}