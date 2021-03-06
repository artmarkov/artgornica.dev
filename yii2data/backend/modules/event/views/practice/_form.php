<?php

use artsoft\widgets\ActiveForm;
use backend\modules\event\models\EventPractice;
use artsoft\helpers\Html;
use artsoft\media\widgets\TinyMce;

/* @var $this yii\web\View */
/* @var $model backend\modules\event\models\EventPractice */
/* @var $form artsoft\widgets\ActiveForm */
?>

<div class="event-practice-form">

    <?php 
    $form = ActiveForm::begin([
            'id' => 'event-practice-form',
            'validateOnBlur' => false,
        ])
    ?>

    <div class="row">
        <div class="col-md-8">

            <div class="panel panel-default">
                <div class="panel-body">

                    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

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
                            <label class="control-label" style="float: left; padding-right: 5px;"><?=  $model->attributeLabels()['id'] ?>: </label>
                            <span><?=  $model->id ?></span>
                        </div>
                        
                        <?php endif; ?> 
                        <?= $form->field($model, 'methods_id')
                            ->dropDownList(backend\modules\event\models\EventMethods::getMethodsList(), [
                                'prompt' => Yii::t('art/event', 'Select Methods...')
                            ])->label(Yii::t('art/event', 'Event Methods'));
                        ?>
                         
                        <?= $form->field($model, 'time_volume')->textInput() ?>   
                        
                        <div class="form-group">
                            <?php  if ($model->isNewRecord): ?>
                                <?= Html::submitButton(Yii::t('art', 'Create'), ['class' => 'btn btn-primary']) ?>
                                <?= Html::a(Yii::t('art', 'Cancel'), ['/event/practice/index'], ['class' => 'btn btn-default']) ?>
                            <?php  else: ?>
                                <?= Html::submitButton(Yii::t('art', 'Save'), ['class' => 'btn btn-primary']) ?>
                                <?= Html::a(Yii::t('art', 'Delete'),
                                    ['/event/practice/delete', 'id' => $model->id], [
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
