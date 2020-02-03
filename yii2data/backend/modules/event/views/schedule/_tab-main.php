<?php

use yii\helpers\Url;
use yii\widgets\Pjax;
use artsoft\grid\GridView;
use artsoft\grid\GridQuickLinks;
use backend\modules\event\models\EventSchedule;
use artsoft\helpers\Html;
use artsoft\grid\GridPageSize;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\event\models\search\EventScheduleSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('art/event', 'Event Schedules');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="event-schedule-index">
    <div class="panel panel-default">
        <div class="panel-body">
            <div class="row">
                <div class="col-sm-12">
                    <h3 class="lte-hide-title page-title"><?= Html::encode($this->title) ?></h3>
                    <?= Html::a(Yii::t('art', 'Add New'), ['/event/schedule/create'], ['class' => 'btn btn-sm btn-primary']) ?>
                </div>
            </div>


            <div class="row">
                <div class="col-sm-6">
                    <?php
                    /* Uncomment this to activate GridQuickLinks */
                    /* echo GridQuickLinks::widget([
                        'model' => EventSchedule::className(),
                        'searchModel' => $searchModel,
                    ])*/
                    ?>
                </div>

                <div class="col-sm-6 text-right">
                    <?= GridPageSize::widget(['pjaxId' => 'event-schedule-grid-pjax']) ?>
                </div>
            </div>

            <?php
            Pjax::begin([
                'id' => 'event-schedule-grid-pjax',
            ])
            ?>

            <?=
            GridView::widget([
                'id' => 'event-schedule-grid',
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'bulkActionOptions' => [
                    'gridId' => 'event-schedule-grid',
                    'actions' => [Url::to(['bulk-delete']) => 'Delete'] //Configure here you bulk actions
                ],
                'columns' => [
                    ['class' => 'artsoft\grid\CheckboxColumn', 'options' => ['style' => 'width:10px']],
                    [
                        'class' => 'artsoft\grid\columns\TitleActionColumn',
                        'controller' => '/event/schedule',
                        'attribute' => 'item_id',
                        'options' => ['style' => 'width:350px'],
                        'label' => Yii::t('art/event', 'Event Name'),
                        'filter' => backend\modules\event\models\EventItem::getEventItemList(),
                        'title' => function (EventSchedule $model) {
                            return Html::a($model->itemProgramm->fullItemName, ['update', 'id' => $model->id], ['data-pjax' => 0]);
                        },
                        'buttonsTemplate' => '{update} {delete}',
                    ],
                    [
                        'attribute' => 'programm_id',
                        'value' => 'programmName',
                        'label' => Yii::t('art/event', 'Programm Name'),
                        'options' => ['style' => 'width:250px'],
                        'filter' => backend\modules\event\models\EventProgramm::getProgrammList(),
                    ],
                    [
                        'attribute' => 'gridUsersSearch',
                        'filter' => backend\modules\event\models\EventSchedule::getScheduleUsersList(),
                        'value' => function (EventSchedule $model) {
                            return implode(',<br>',
                                yii\helpers\ArrayHelper::map($model->scheduleUsers, 'id', 'fullName'));
                        },
                        'options' => ['style' => 'width:250px'],
                        'format' => 'raw',
                    ],
                    [
                        'attribute' => 'place_id',
                        'value' => 'placeName',
                        'label' => Yii::t('art/event', 'Place Name'),
                        'filter' => backend\modules\event\models\EventPlace::getPlacesList(),
                        'options' => ['style' => 'width:100px'],
                    ],
                    [
                        'attribute' => 'start_timestamp',
                        'options' => ['style' => 'width:150px'],
                        'format' => 'datetime',

                    ],
                    [
                        'attribute' => 'end_timestamp',
                        'options' => ['style' => 'width:150px'],
                        'format' => 'datetime',

                    ],
                ],
            ]);
            ?>

            <?php Pjax::end() ?>
        </div>
    </div>
</div>


