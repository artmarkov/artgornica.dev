<?php

use yii\helpers\Url;
use yii\widgets\Pjax;
use artsoft\grid\GridView;
use artsoft\grid\GridQuickLinks;
use backend\modules\event\models\EventProgramm;
use artsoft\helpers\Html;
use artsoft\grid\GridPageSize;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\event\models\search\EventProgrammSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('art/event', 'Event Programms');
$this->params['breadcrumbs'][] = ['label' => Yii::t('art/event', 'Events'), 'url' => ['default/index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="event-programm-index">

    <div class="row">
        <div class="col-sm-12">
            <h3 class="lte-hide-title page-title"><?= Html::encode($this->title) ?></h3>
            <?= Html::a(Yii::t('art', 'Add New'), ['/event/programm/create'], ['class' => 'btn btn-sm btn-primary']) ?>
        </div>
    </div>

    <div class="panel panel-default">
        <div class="panel-body">

            <div class="row">
                <div class="col-sm-6">
                    <?php
                    /* Uncomment this to activate GridQuickLinks */
                    /* echo GridQuickLinks::widget([
                      'model' => EventProgramm::className(),
                      'searchModel' => $searchModel,
                      ]) */
                    ?>
                </div>

                <div class="col-sm-6 text-right">
                    <?= GridPageSize::widget(['pjaxId' => 'event-programm-grid-pjax']) ?>
                </div>
            </div>

            <?php
            Pjax::begin([
                'id' => 'event-programm-grid-pjax',
            ])
            ?>

            <?=
            GridView::widget([
                'id' => 'event-programm-grid',
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'bulkActionOptions' => [
                    'gridId' => 'event-programm-grid',
                    'actions' => [Url::to(['bulk-delete']) => 'Delete'] //Configure here you bulk actions
                ],
                'columns' => [
                    ['class' => 'artsoft\grid\CheckboxColumn', 'options' => ['style' => 'width:10px']],
                    [
                        'class' => 'artsoft\grid\columns\TitleActionColumn',
                        'attribute' => 'name',
                        'controller' => '/event/programm',
                        'options' => ['style' => 'width:300px'],
                        'title' => function(EventProgramm $model) {
                            return Html::a($model->name, ['update', 'id' => $model->id], ['data-pjax' => 0]);
                        },
                        'buttonsTemplate' => '{update} {delete}'
                    ],
                    [
                        'attribute' => 'vid_id',
                        'value' => 'vidName',
                        'label' => Yii::t('art/event', 'Vid Name'),
                        'filter' => backend\modules\event\models\EventVid::getVidList(),
                        'options' => ['style' => 'width:300px'],
                    ],
                    [
                        'attribute' => 'gridItemsSearch',
                        'filter' => backend\modules\event\models\EventItem::getEventItemList(),
                        'value' => function (EventProgramm $model) {
                            return implode(',<br>',
                                ArrayHelper::map($model->eventItems, 'id', 'name'));
                        },
                        'options' => ['style' => 'width:600px'],
                        'format' => 'raw',
                    ],
                    'item_hours',
                    [
                        'attribute' => 'mediaFirst',
                        'value' => function ($model)
                                {
                        $item = \artsoft\mediamanager\models\MediaManager::getMediaFirst($model->className(), $model->id);
                        !empty($item) ? $img = \artsoft\media\models\Media::findById($item['media_id'])->getThumbs()['small'] : $img = '/images/noimg.png';
                            return Html::img($img, ['class'=> 'dw-media-image']);
                    },
                            'format' => 'html',
                    ],       
                    
//                    [
//                        'attribute' => 'fullPrice',
//                        'options' => ['style' => 'width:150px'],
//                        'value' => function ($model)
//                                {
//                                    return $model->fullPrice . ' ' . Yii::t('art/event', 'руб');
//                                }
//                    ],
//                    [
//                        'attribute' => 'programm_price',
//                        'options' => ['style' => 'width:150px'],
//                        'value' => function ($model)
//                                {
//                                    return empty($model->programm_price)? NULL : $model->programm_price . ' ' . Yii::t('art/event', 'руб');
//                                }
//                    ],
//                    [
//                        'attribute' => 'countItem',
//                        'value' => function ($model)
//                                {
//                        return backend\modules\event\models\EventItemProgramm::getCountItem($model->id);
//                        
//                    },
//                    ],
//                    [
//                        'attribute' => 'programmHours',
//                        'value' => function ($model)
//                                {
//                        return backend\modules\event\models\EventItemProgramm::getCountItem($model->id) * $model->item_hours;
//                        
//                    },
//                    ], 
//            'id',
//            'vid_id',
//            'name',
//            'description:ntext',
                ],
            ]);
            ?>

            <?php Pjax::end() ?>
        </div>
    </div>
</div>


