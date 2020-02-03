<?php

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\event\models\search\EventPlanSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

?>
<!--<div class="event-plan-index">-->
<!--    <div class="tabs nomargin-top">-->

        <?= \yii\bootstrap\Tabs::widget([
            'encodeLabels' => false,
            'id' => 'tabs_event_plan',
            'items' => [
                [
                    'label' => '<i class="fa fa-calendar-o"></i> ' . Yii::t('art/event', 'Schedule Calendar'),
                    'content' => $this->render('fullcalendar'),
                ],
                [
                    'label' => '<i class="fa fa-pencil-square-o"></i> ' . Yii::t('art/event', 'Event Schedules'),
                    'content' => $this->render('_tab-main', ['dataProvider' => $dataProvider,
                        'searchModel' => $searchModel,]),
                ],
            ],
        ])
        ?>
<!--    </div>-->
<!--</div>-->


