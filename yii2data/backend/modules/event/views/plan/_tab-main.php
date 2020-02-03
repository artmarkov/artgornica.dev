<?php

use yii\helpers\Url;
use yii\widgets\Pjax;
use artsoft\grid\GridView;
use artsoft\grid\GridQuickLinks;
use backend\modules\event\models\EventPlan;
use artsoft\helpers\Html;
use artsoft\grid\GridPageSize;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\event\models\search\EventPlanSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('art/event','Event Plans');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="event-plan-main">
    <div class="panel panel-default">
        <div class="panel-body">
            <div class="row">
                <div class="col-sm-12">
                    <h3 class="lte-hide-title page-title"><?= Html::encode($this->title) ?></h3>
                    <?= Html::a(Yii::t('art', 'Add New'), ['/event/plan/create'], ['class' => 'btn btn-sm btn-primary']) ?>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6">
                    <?php
                    /* Uncomment this to activate GridQuickLinks */
                    /* echo GridQuickLinks::widget([
                        'model' => EventPlan::className(),
                        'searchModel' => $searchModel,
                    ])*/
                    ?>
                </div>

                <div class="col-sm-6 text-right">
                    <?= GridPageSize::widget(['pjaxId' => 'event-plan-grid-pjax']) ?>
                </div>
            </div>

            <?php
            Pjax::begin([
                'id' => 'event-plan-grid-pjax',
            ])
            ?>

            <?=
            GridView::widget([
                'id' => 'event-plan-grid',
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'bulkActionOptions' => [
                    'gridId' => 'event-plan-grid',
                    'actions' => [Url::to(['bulk-delete']) => 'Delete'] //Configure here you bulk actions
                ],
                'columns' => [
                    ['class' => 'artsoft\grid\CheckboxColumn', 'options' => ['style' => 'width:10px']],
                    [
                        'class' => 'artsoft\grid\columns\TitleActionColumn',
                        'controller' => '/event/plan',
                        'attribute' => 'programm_id',
                        'options' => ['style' => 'width:350px'],
                        'label' => Yii::t('art/event', 'Programm Name'),
                        'filter' => backend\modules\event\models\EventProgramm::getProgrammList(),
                        'title' => function (EventPlan $model) {
                            return Html::a($model->programmName, ['update', 'id' => $model->id], ['data-pjax' => 0]);
                        },
                        'buttonsTemplate' => '{update} {delete}',
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


