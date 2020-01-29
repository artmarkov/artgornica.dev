<?php

use artsoft\helpers\Html;
use kartik\select2\Select2;
use yii\widgets\Pjax;
use himiklab\sortablegrid\SortableGridView;
use backend\modules\event\models\EventItemPractice;

?>

<div class="item-practice-widget">
    <div class="panel panel-default">
        <div class="panel-body">    
            <div class="row">   
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-8">

                            <?= Select2::widget([
                                'id' => 'eventpractice-practice_list',
                                'data' => backend\modules\event\models\EventPractice::getEventPracticeList(),
                                'name' => 'practice_list',
                                'options' => [
                                    'placeholder' => Yii::t('art/event', 'Select Practice...'),
                                    'multiple' => true,
                                ], 'pluginOptions' => [
                                    'allowClear' => true,
                                ],
                                'addon' => [
                                    'append' => [
                                        'content' => Html::a(Yii::t('art', 'Add'), ['#'], [
                                            'class' => 'btn btn-primary add-to-item-practice',
                                            'data-id' => $model->id,
                                        ]),
                                        'asButton' => true,
                                    ],
                                ],
                            ]);
                            ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <?php Pjax::begin(); ?>  

                            <?=
                            SortableGridView::widget([
                                'id' => 'nested-grid',
                                'dataProvider' => $dataProvider,
                                'sortableAction' => ['item-practice/sort'],
                                //'filterModel' => $searchModel,
                                'layout' => '{items}',
                                'tableOptions' => ['class' => 'table table-striped'],
                                'showFooter' => true,
                                'columns' => [
                                    ['class' => 'yii\grid\SerialColumn'],
                                    [
                                        'attribute' => 'practiceName',
                                        'value' => function (EventItemPractice $model) {
                                            return $model->practiceName;
                                        },
                                    'footer' => '<strong>Всего:</strong>',
                                    ], 
                                    [
                                        'attribute' => 'practiceTimeVolume',
                                        'value' => function (EventItemPractice $model) {
                                            return $model->practiceTimeVolume;
                                        },
                                    'footer' => '<strong>' . EventItemPractice::getItemTime($model->id) . '</strong>',
                                    ],
                                    [
                                        'options' => ['style' => 'width:20px'],
                                        'format' => 'raw',
                                        'value' => function ($model) {
                                            return Html::a('<span class="glyphicon glyphicon-trash" aria-hidden="true"></span>', ['#'], [
                                                        'title' => Yii::t('yii', 'Delete'),
                                                        'class' => 'btn btn-sm btn-danger remove-practice',
                                                        'data-id' => $model->id,
                                            ]);
                                        },
                                    ],
                                ],
                            ]);
                            ?>
                            <?php Pjax::end(); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



<?php
$js = <<<JS

$('.add-to-item-practice').on('click', function (e) {

    e.preventDefault();
    
    var id = $(this).data('id'),
        practice_list = $('#eventpractice-practice_list').val();

    $.ajax({
        url: '/admin/event/item-practice/create-practice',
        data: {id: id, practice_list: practice_list},
        type: 'POST',
       
    });
});

$('.remove-practice').on('click', function (e) {

    e.preventDefault();
    
    var id = $(this).data('id');

    $.ajax({
        url: '/admin/event/item-practice/remove',
        data: {id: id},
        type: 'POST'
    });
});

JS;

$this->registerJs($js);
?>
<?php
$css = <<<CSS
        
    #nested-grid.grid-view tbody tr td {
        height: auto !important; 
    }
        
CSS;

$this->registerCss($css);
?>

