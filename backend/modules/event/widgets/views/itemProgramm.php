<?php

use artsoft\widgets\ActiveForm;
use artsoft\helpers\Html;
use kartik\select2\Select2;
use yii\widgets\Pjax;
use himiklab\sortablegrid\SortableGridView;
use yii\helpers\ArrayHelper;

?>
<?php $form = ActiveForm::begin(); ?>

<div class="works-author-widget">
    <div class="panel panel-default">
        <div class="panel-body">
            <div class="row">
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-6">

                             <?=
                            $form->field($model, 'item_id')->widget(Select2::classname(), [

                                'data' => backend\modules\event\models\EventItem::getEventItemByName(),  
                                'theme' => Select2::THEME_KRAJEE,
                                'options' => ['placeholder' => Yii::t('art/event', 'Select Events...')],
                                'pluginOptions' => [
                                    'allowClear' => true,
                                ],
                                'addon' => [
                                    'append' => [
                                        'content' => Html::a(Yii::t('art', 'Add'), ['#'], [
                                                'class' => 'btn btn-primary add-to-item-programm',
                                           'data-id' => $model->id,
                                        ]),
                                        'asButton' => true,
                                    ],
                                ],
                             ])->label(Yii::t('art/event', 'Events List'));
                            ?>
                           
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <?php Pjax::begin(); ?>
   
<?php

        $dataProvider = new \yii\data\ActiveDataProvider([
            'query' => \backend\modules\event\models\EventItemProgramm::find()
                ->andWhere(['in', 'programm_id' , $model->id])
                ->orderBy('sortOrder'),
            'sort' => false,
        ]);
        $dataProvider->pagination = false;
?>
    <?= SortableGridView::widget([
        'id' => 'nested-grid',
        'dataProvider' => $dataProvider,
        'sortableAction' => ['item-programm/sort'],        
        //'filterModel' => $searchModel,
        'layout' => '{items}',
        'tableOptions' => ['class' => 'table table-striped'],
        'showFooter' => true,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
           
            [
               'attribute' => 'fullItemName',
               'value' => function (\backend\modules\event\models\EventItemProgramm $model) {
                    return $model->fullItemName;
                },                        
//               'footer' => '<strong>Всего:</strong>',
            ],    
//            'name_short',
//            [
//                'attribute' =>  'price',
//                'value' => function (\backend\modules\event\models\EventItemProgramm $model) {
//                    return $model->price;
//                },
//                'footer' => '<strong>' . $model->fullPrice. ' ' . Yii::t('art/event', 'руб') . '</strong>',
//            ],
            'timeVolume',
            [
                'attribute' => 'gridPractice',
                'value' => function (\backend\modules\event\models\EventItemProgramm $model) {
                    return implode(', ',
                        ArrayHelper::map($model->itemProgrammPractices, 'id', 'name'));
                },
                'format' => 'raw',
            ],   
            [
            'options' => ['style' => 'width:20px'],
            'format' => 'raw',
            'value' => function ($model) {
                return Html::a('<span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>', ['#'], [
                            'title' => Yii::t('yii', 'Update'),
                            'class' => 'btn btn-sm btn-primary update-programm',
                            'data-id' => $model->id,
                ]);
            },
            ],
            [
            'options' => ['style' => 'width:20px'],
            'format' => 'raw',
            'value' => function ($model) {
                return Html::a('<span class="glyphicon glyphicon-trash" aria-hidden="true"></span>', ['#'], [
                            'title' => Yii::t('yii', 'Delete'),
//                          'data-confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
                            'class' => 'btn btn-sm btn-danger remove-programm',
                            'data-id' => $model->id,
                ]);
            },
        ],
    ],
    ]); ?>
    <?php Pjax::end(); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php ActiveForm::end(); ?>

<?php
$js = <<<JS

function showProgramm(author) {
    $('#item-programm-modal .modal-body').html(author);
    $('#item-programm-modal').modal();
}

$('.add-to-item-programm').on('click', function (e) {

    e.preventDefault();
    
    var id = $(this).data('id'),
        item_id = $('#eventprogramm-item_id').val();

    $.ajax({
        url: '/admin/event/item-programm/init-programm',
        data: {id: id, item_id: item_id},
        type: 'GET',
        success: function (res) {
            if (!res)  alert('Please select event...');
           // console.log(res);
           else showProgramm(res);
        },
        error: function () {
            alert('Script Error!');
        }
    });
});

$('.update-programm').on('click', function (e) {

    e.preventDefault();

    var id = $(this).data('id');

    $.ajax({
        url: '/admin/event/item-programm/update-programm',
        data: {id: id},
        type: 'GET',
        success: function (res) {
            if (!res)  alert('Error!');
           // console.log(res);
           else showProgramm(res);
        },
        error: function () {
            alert('Error!');
        }
    });
});

$('.remove-programm').on('click', function (e) {

    e.preventDefault();
    
    var id = $(this).data('id');

    $.ajax({
        url: '/admin/event/item-programm/remove',
        data: {id: id},
        type: 'GET'
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