<?php

use artsoft\widgets\ActiveForm;
use artsoft\helpers\Html;
use backend\modules\media\widgets\TinyMce;

/* @var $this yii\web\View */
/* @var $model backend\modules\event\models\EventProgramm */
/* @var $form artsoft\widgets\ActiveForm */
?>

<div class="event-programm-form">

    <?php 
    $form = ActiveForm::begin([
            'id' => 'event-programm-form',
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
           <div class="panel panel-default">
                <div class="panel-body">
                    <?php if (!$model->isNewRecord) : ?>
                        <?= backend\modules\event\widgets\ItemProgrammWidget::widget(['model' => $model]); ?>
                    <?php endif; ?>
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
                            
                        <?php endif; ?>
                        <?= $form->field($model, 'vid_id')
                                ->dropDownList(backend\modules\event\models\EventVid::getVidList(), [
                                    'prompt' => Yii::t('art/event', 'Select Vid...'),
                                    'id' => 'vid_id'
                                ])->label(Yii::t('art/event', 'Event Vid'));
                            ?>
<!--                        
                        <?php  $count = \backend\modules\event\models\EventItemProgramm::getCountItem($model->id);
                            $hint_price = 'Расчет полной стоимости: ' . $count . 'x' . $model->item_price . '=' . ($count*$model->item_price) . ' ₽';
                        ?>
                        
                        <?= $form->field($model, 'programm_price')->textInput(['maxlength' => true])->hint($hint_price) ?>
                        -->
                        <?= $form->field($model, 'item_hours')->textInput(['maxlength' => true]) ?>
<!--                        
                        <?= $form->field($model, 'item_price')->textInput(['maxlength' => true]) ?>
                        -->
                        
                        <div class="form-group clearfix">
                            <label class="control-label" style="float: left; padding-right: 5px;"><?=  $model->attributeLabels()['id'] ?>: </label>
                            <span><?=  $model->id ?></span>
                        </div>

                        <div class="form-group">
                            <?php  if ($model->isNewRecord): ?>
                                <?= Html::submitButton(Yii::t('art', 'Create'), ['class' => 'btn btn-primary']) ?>
                                <?= Html::a(Yii::t('art', 'Cancel'), ['/event/programm/index'], ['class' => 'btn btn-default']) ?>
                            <?php  else: ?>
                                <?= Html::submitButton(Yii::t('art', 'Save'), ['class' => 'btn btn-primary']) ?>
                                <?= Html::a(Yii::t('art', 'Delete'),
                                    ['/event/programm/delete', 'id' => $model->id], [
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
<!--        модал добавления занятия в программу-->
        <?php \yii\bootstrap\Modal::begin([
            'header' => '<h3 class="lte-hide-title page-title">' . Yii::t('art/event', 'Events') . '</h3>',
           // 'size' => 'modal-sm',
            'id' => 'item-programm-modal',
            //'footer' => 'footer',
        ]);

        \yii\bootstrap\Modal::end(); ?>