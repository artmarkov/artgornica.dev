<?php

use artsoft\widgets\ActiveForm;
use backend\modules\event\models\EventProgramm;
use artsoft\helpers\Html;
use kartik\color\ColorInput;
use artsoft\media\widgets\TinyMce;

/* @var $this yii\web\View */
/* @var $model backend\modules\event\models\EventPlan */
/* @var $form artsoft\widgets\ActiveForm */
?>

<div class="event-plan-form">

    <?php 
    $form = ActiveForm::begin([
            'id' => 'event-plan-form',
            'validateOnBlur' => false,
        ])
    ?>

    <div class="row">
        <div class="col-md-8">

            <div class="panel panel-default">
                <div class="panel-body">
                    
                     <?= $form->field($model, 'programm_id')->dropDownList(EventProgramm::getProgrammList(), [
                            'prompt' => Yii::t('art/event', 'Select Programm...'),
                            'id' => 'programm_id'
                        ])->label(Yii::t('art/event', 'Programm Name')); ?>

                     <?= $form->field($model, 'description')->widget(TinyMce::className()); ?>
                  
                </div>

            </div>
        </div>

        <div class="col-md-4">

            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="record-info">
                         <?php if (!$model->isNewRecord): ?>

                            <div class="form-group clearfix">
                                <label class="control-label" style="float: left; padding-right: 5px;">
                             <?= $model->attributeLabels()['created_at'] ?> :
                                </label>
                                <span><?= $model->createdDatetime ?></span>                                
                            </div>

                            <div class="form-group clearfix">
                                <label class="control-label" style="float: left; padding-right: 5px;">
                             <?= $model->attributeLabels()['updated_at'] ?> :
                                </label>
                                <span><?= $model->updatedDatetime ?></span>
                            </div>
                           
                        <?php endif; ?>
                       
                        <?=  $form->field($model, 'place_id')
                            ->dropDownList(backend\modules\event\models\EventPlace::getPlacesList(), [
                                'prompt' => Yii::t('art/event', 'Select Places...')
                            ])->label(Yii::t('art/event', 'Place Name'));
                        ?>
                         <?= $form->field($model, 'color')->widget(ColorInput::classname(), [
                            'options' => ['placeholder' => 'Select color ...'],
                            'pluginOptions' => ['preferredFormat' => 'rgb']
                        ]);
                        ?>
                        <?= $form->field($model, 'start_time')->widget(kartik\datetime\DateTimePicker::classname())->widget(\yii\widgets\MaskedInput::className(), ['mask' => Yii::$app->settings->get('reading.date_time_mask')])->textInput(); ?>

                        <?= $form->field($model, 'end_time')->widget(kartik\datetime\DateTimePicker::classname())->widget(\yii\widgets\MaskedInput::className(), ['mask' => Yii::$app->settings->get('reading.date_time_mask')])->textInput() ?>
                       
                        <div class="form-group">
                            <?php  if ($model->isNewRecord): ?>
                                <?= Html::submitButton(Yii::t('art', 'Create'), ['class' => 'btn btn-primary']) ?>
                                <?= Html::a(Yii::t('art', 'Cancel'), ['/event/plan/index'], ['class' => 'btn btn-default']) ?>
                            <?php  else: ?>
                               <div class="form-group clearfix">
                               <label class="control-label" style="float: left; padding-right: 5px;"><?=  $model->attributeLabels()['id'] ?>: </label>
                               <span><?=  $model->id ?></span>
                               </div>
                                <?= Html::submitButton(Yii::t('art', 'Save'), ['class' => 'btn btn-primary']) ?>
                                <?= Html::a(Yii::t('art', 'Delete'),
                                    ['/event/plan/delete', 'id' => $model->id], [
                                    'class' => 'btn btn-danger',
                                    'data' => [
                                        'confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
                                        'method' => 'post',
                                    ],
                                ]) ?>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <?php  ActiveForm::end(); ?>

</div>
