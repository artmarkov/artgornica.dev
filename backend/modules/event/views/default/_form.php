<?php

use artsoft\widgets\ActiveForm;
use backend\modules\event\models\EventItem;
use backend\modules\event\models\EventPractice;
use artsoft\helpers\Html;
use backend\modules\media\widgets\TinyMce;

/* @var $this yii\web\View */
/* @var $model backend\modules\event\models\EventItem */
/* @var $form artsoft\widgets\ActiveForm */
?>

<div class="event-item-form">

    <?php 
    $form = ActiveForm::begin([
            'id' => 'event-item-form',
            'validateOnBlur' => false,
        ])
    ?>

    <div class="row">
        <div class="col-md-9">

            <div class="panel panel-default">
                <div class="panel-body">
                    
                    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

                    <?= $form->field($model, 'description')->widget(TinyMce::className()); ?>
                    
                    <?= $form->field($model, 'assignment')->widget(TinyMce::className()); ?>

                </div>
       
            </div>
             <?php if (!$model->isNewRecord) : ?>
            
            <div class="panel panel-default">
                <div class="panel-body">
                    
                    <?= \backend\modules\mediamanager\widgets\MediaManagerWidget::widget(['model' => $model]); ?>
                    
                </div> 
            </div>
            
            <?php endif; ?>
        </div>

        <div class="col-md-3">

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
                            <div class="form-group clearfix">
                                <label class="control-label" style="float: left; padding-right: 5px;">
                                    <?= $model->attributeLabels()['timeVolume'] ?> :
                                </label>
                                <span><?= $model->timeVolume . ' ' . Yii::t('art/event', 'min'); ?></span>
                            </div>
                        <?php endif; ?>
                     
                        <?= $form->field($model, 'practice_list')->widget(kartik\select2\Select2::className(), [
                            'data' => EventPractice::getEventPracticeList(),
                            'options' => [
                                'placeholder' => Yii::t('art/event', 'Select Practice...'), 
                                'multiple' => true
                            ],                              
                        ])
                        ?>
                    
                        <div class="form-group clearfix">
                            <label class="control-label" style="float: left; padding-right: 5px;"><?=  $model->attributeLabels()['id'] ?>: </label>
                            <span><?=  $model->id ?></span>
                        </div>

                        <div class="form-group">
                            <?php  if ($model->isNewRecord): ?>
                                <?= Html::submitButton(Yii::t('art', 'Create'), ['class' => 'btn btn-primary']) ?>
                                <?= Html::a(Yii::t('art', 'Cancel'), ['/event/default/index'], ['class' => 'btn btn-default']) ?>
                            <?php  else: ?>
                                <?= Html::submitButton(Yii::t('art', 'Save'), ['class' => 'btn btn-primary']) ?>
                                <?= Html::a(Yii::t('art', 'Delete'),
                                    ['/event/default/delete', 'id' => $model->id], [
                                    'class' => 'btn btn-default',
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
