<?php

use yii\helpers\Url;
use yii\widgets\Pjax;
use artsoft\grid\SortableGridView;
use artsoft\grid\GridQuickLinks;
use backend\modules\event\models\EventItem;
use backend\modules\event\models\EventPractice;
use artsoft\helpers\Html;
use artsoft\grid\GridPageSize;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\event\models\search\EventItemSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('art/event', 'Events');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="event-item-index">

    <div class="row">
        <div class="col-sm-12">
            <h3 class="lte-hide-title page-title"><?=  Html::encode($this->title) ?></h3>
            <?= Html::a(Yii::t('art', 'Add New'), ['/event/default/create'], ['class' => 'btn btn-sm btn-primary']) ?>
        </div>
    </div>

    <div class="panel panel-default">
        <div class="panel-body">

            <div class="row">
                <div class="col-sm-6">
                    <?php 
                    /* Uncomment this to activate GridQuickLinks */
                    /* echo GridQuickLinks::widget([
                        'model' => EventItem::className(),
                        'searchModel' => $searchModel,
                    ])*/
                    ?>
                </div>

                <div class="col-sm-6 text-right">
                    <?=  GridPageSize::widget(['pjaxId' => 'event-item-grid-pjax']) ?>
                </div>
            </div>

            <?php 
            Pjax::begin([
                'id' => 'event-item-grid-pjax',
            ])
            ?>

            <?= SortableGridView::widget([
                'id' => 'event-item-grid',
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'bulkActionOptions' => [
                    'gridId' => 'event-item-grid',
                    'actions' => [ Url::to(['bulk-delete']) => 'Delete'] //Configure here you bulk actions
                ],
                'columns' => [
                    ['class' => 'artsoft\grid\CheckboxColumn', 'options' => ['style' => 'width:10px']],
                    ['class' => 'yii\grid\SerialColumn', 'options' => ['style' => 'width:20px']],                    
                    [
                        'class' => 'artsoft\grid\columns\TitleActionColumn',
                        'controller' => '/event/default',
                        'attribute' => 'name',
                        'title' => function(EventItem $model) {
                            return Html::a($model->name, ['update', 'id' => $model->id], ['data-pjax' => 0]);
                        },
                        'buttonsTemplate' => '{update} {delete}',
                    ],
                    [
                        'attribute' => 'gridPracticeSearch',
                        'filter' => EventPractice::getEventPracticeList(),
                        'value' => function (EventItem $model) {
                            return implode(', ',
                                ArrayHelper::map($model->eventPractices, 'id', 'name'));
                        },
                        'options' => ['style' => 'width:350px'],
                        'format' => 'raw',
                    ],                  
                    [
                        'attribute' => 'timeVolume',
                        'value' => function (EventItem $model) {
                            return $model->timeVolume . ' ' . Yii::t('art/event', 'min');
                        },
//                        'label' => Yii::t('art/event', 'Event Vid'),
//                        'filter' => backend\modules\event\models\EventVid::getVidList(),
//                        'options' => ['style' => 'width:300px'],
                    ],
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
//              'timeVolume',
//            'id',
//            'name',
//            'description:ntext',
//            'created_at',
//            'updated_at',

                ],
            ]);
            ?>

            <?php Pjax::end() ?>
        </div>
    </div>
</div>


