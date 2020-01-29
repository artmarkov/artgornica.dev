<?php

use artsoft\widgets\ActiveForm;
use backend\modules\event\models\EventPlace;
use artsoft\helpers\Html;
use yii\widgets\MaskedInput;
use kartik\color\ColorInput;

/* @var $this yii\web\View */
/* @var $model backend\modules\event\models\EventPlace */
/* @var $form artsoft\widgets\ActiveForm */
?>

<div class="event-place-form">

    <?php 
    $form = ActiveForm::begin([
            'id' => 'event-place-form',
            'validateOnBlur' => false,
        ])
    ?>

    <div class="row">
         <div class="col-md-9">

            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-12">
                            <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <?= $form->field($model, 'phone')
                                ->widget(MaskedInput::className(), ['mask' => Yii::$app->settings->get('reading.phone_mask')])->textInput() 
                            ?>
                        </div>
                        <div class="col-md-6">
                            <?= $form->field($model, 'phone_optional')
                                ->widget(MaskedInput::className(), ['mask' => Yii::$app->settings->get('reading.phone_mask')])->textInput() 
                            ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>
                        </div>
                        <div class="col-md-6">
                            <?= $form->field($model, 'сontact_person')->textInput(['maxlength' => true]) ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <?= $form->field($model, 'description')->textarea(['rows' => '3', 'maxlength' => true]) ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <?= $form->field($model, 'address')->textInput(['maxlength' => true]) ?>
                          <div class="help-block"><?= \Yii::t('art', 'Click on the map to get the address and coordinates, then click the button to insert the address into the form'); ?></div>
                       
                        </div>
                    </div>

                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-12">
                            <?= $form->field($model, 'coords')->widget(\common\widgets\YandexGetCoordsWidget::className())->label(false) ?>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <div class="col-md-3">

            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="record-info">
                        <?=
                        $form->field($model, 'event_color')->widget(ColorInput::classname(), [
                            'options' => ['placeholder' => 'Select color ...'],
                            'pluginOptions' => ['preferredFormat' => 'rgb']
                        ]);
                        ?>

                        <?=
                        $form->field($model, 'event_text_color')->widget(ColorInput::classname(), [
                            'options' => ['placeholder' => 'Select color ...'],
                            'pluginOptions' => ['preferredFormat' => 'rgb']
                        ]);
                        ?>
                    </div>
                </div>
            </div>
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
                        
                        <div class="form-group clearfix">
                            <label class="control-label" style="float: left; padding-right: 5px;"><?=  $model->attributeLabels()['id'] ?>: </label>
                            <span><?=  $model->id ?></span>
                        </div>

                        <div class="form-group">
                            <?php  if ($model->isNewRecord): ?>
                                <?= Html::submitButton(Yii::t('art', 'Create'), ['class' => 'btn btn-primary']) ?>
                                <?= Html::a(Yii::t('art', 'Cancel'), ['/event/place/index'], ['class' => 'btn btn-default']) ?>
                            <?php  else: ?>
                                <?= Html::submitButton(Yii::t('art', 'Save'), ['class' => 'btn btn-primary']) ?>
                                <?= Html::a(Yii::t('art', 'Delete'),
                                    ['/event/place/delete', 'id' => $model->id], [
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

<?php
$js = <<<JS
$('.insert-coords-form').on('click', function (e) {
    e.preventDefault();   
    document.getElementById('eventplace-address').value = $('#eventplace-map_address').val();       
 });
JS;
$this->registerJs($js);