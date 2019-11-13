<?php

use artsoft\widgets\ActiveForm;
use artsoft\helpers\Html;
use kartik\sortable\Sortable;
use kartik\sortinput\SortableInput;
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
                    
                           
                    <?= $form->field($model, 'practice_list')->widget(kartik\select2\Select2::className(), [
                        'data' => backend\modules\event\models\EventPractice::getEventPracticeList(),
                        'options' => [
                            'placeholder' => Yii::t('art/event', 'Select Practice...'), 
                            'multiple' => true
                        ], 'pluginOptions' => [
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
                    <?php
                    
                            echo SortableInput::widget([
                                'name' => 'sort_list',
//                                  'sortableOptions' => ['type' => Sortable::TYPE_GRID],
                                'items' => [],
                                 'hideInput' => false,
                                 'options' => ['id' => 'practice-sort', 'class' => 'form-control', 'readonly' => true]
                            ]);
                            echo '<div class="clearfix"></div>';
                            ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php ActiveForm::end(); ?>
