<?php

use artsoft\grid\GridPageSize;
use artsoft\grid\GridQuickLinks;
use artsoft\grid\GridView;
use artsoft\helpers\Html;
use artsoft\models\User;
use backend\modules\post\models\Post;
use yii\helpers\Url;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\post\models\search\PostSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('art/post', 'Posts');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="post-index">

    <div class="row">
        <div class="col-sm-12">
            <h3 class="lte-hide-title page-title"><?= Html::encode($this->title) ?></h3>
            <?= Html::a(Yii::t('art', 'Add New'), ['create'], ['class' => 'btn btn-sm btn-primary']) ?>
            <?= Html::a(Yii::t('art/media', 'Categories'), ['/post/category/index'], ['class' => 'btn btn-sm btn-primary']) ?>
        </div>
    </div>

    <div class="panel panel-default">
        <div class="panel-body">

            <div class="row">
                <div class="col-sm-6">
                    <?= GridQuickLinks::widget([
                        'model' => Post::className(),
                        'searchModel' => $searchModel,
                        'labels' => [
                            'all' => Yii::t('art', 'All'),
                            'active' => Yii::t('art', 'Published'),
                            'inactive' => Yii::t('art', 'Pending'),
                        ]
                    ]) ?>
                </div>

                <div class="col-sm-6 text-right">
                    <?= GridPageSize::widget(['pjaxId' => 'post-grid-pjax']) ?>
                </div>
            </div>

            <?php
            Pjax::begin([
                'id' => 'post-grid-pjax',
            ])
            ?>

            <?=
            GridView::widget([
                'id' => 'post-grid',
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'bulkActionOptions' => [
                    'gridId' => 'post-grid',
                    'actions' => [
                        Url::to(['bulk-activate']) => Yii::t('art', 'Publish'),
                        Url::to(['bulk-deactivate']) => Yii::t('art', 'Unpublish'),
                        Url::to(['bulk-delete']) => Yii::t('yii', 'Delete'),
                    ]
                ],
                'columns' => [
                    ['class' => 'artsoft\grid\CheckboxColumn', 'options' => ['style' => 'width:10px']],
                    [
                        'class' => 'artsoft\grid\columns\TitleActionColumn',
                        'controller' => '/post/default',
                        'title' => function (Post $model) {
                            return Html::a($model->title, ['update', 'id' => $model->id], ['data-pjax' => 0]);
                        },
                        'buttonsTemplate' => '{update} {delete}',
                    ],
                    [
                        'attribute' => 'created_by',
                        'filter' => artsoft\models\User::getUsersList(),
                        'value' => function (Post $model) {
                            return Html::a($model->author->username,
                                ['/user/default/update', 'id' => $model->created_by],
                                ['data-pjax' => 0]);
                        },
                        'format' => 'raw',
                        'visible' => User::hasPermission('viewUsers'),
                        'options' => ['style' => 'width:180px'],
                    ],
                    [
                        'class' => 'artsoft\grid\columns\StatusColumn',
                        'attribute' => 'main_flag',
                        'optionsArray' => Post::getMainOptionsList(),
                        'options' => ['style' => 'width:60px'],
                    ],
                    [
                        'class' => 'artsoft\grid\columns\StatusColumn',
                        'attribute' => 'status',
                        'optionsArray' => Post::getStatusOptionsList(),
                        'options' => ['style' => 'width:60px'],
                    ],
                    [
                        'class' => 'artsoft\grid\columns\DateFilterColumn',
                        'attribute' => 'published_at',
                        'value' => function (Post $model) {
                            return '<span style="font-size:85%;" class="label label-'
                            . ((time() >= $model->published_at) ? 'primary' : 'default') . '">'
                            . $model->publishedDate . '</span>';
                        },
                        'format' => 'raw',
                        'options' => ['style' => 'width:150px'],
                    ],
                ],
            ]);
            ?>

            <?php Pjax::end() ?>
        </div>
    </div>
</div>


