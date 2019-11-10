<?php

use artsoft\widgets\ActiveForm;
use backend\modules\event\models\EventProgramm;
use backend\modules\event\models\EventItem;
use artsoft\helpers\Html;
use kartik\depdrop\DepDrop;
use yii\helpers\Url;
use backend\modules\media\widgets\TinyMce;

/* @var $this yii\web\View */
/* @var $model backend\modules\event\models\EventSchedule */
/* @var $form artsoft\widgets\ActiveForm */
?>

<div class="event-schedule-form">

    <?php
    $form = ActiveForm::begin([
                'id' => 'event-schedule-form',
                'validateOnBlur' => false,
            ])
    ?>

    <div class="row">
        <div class="col-md-9">

            <div class="panel panel-default">
                <div class="panel-body">
                        <?php

                        echo $form->field($model, 'programm_id')->dropDownList(EventProgramm::getProgrammList(), [
                            'prompt' => Yii::t('art/event', 'Select Programm...'),
                            'id' => 'programm_id'
                        ])->label(Yii::t('art/event', 'Programm Name'));

                        echo $form->field($model, 'item_programm_id')->widget(DepDrop::classname(), [
                            'data' => backend\modules\event\models\EventItemProgramm::getItemByName($model->programm_id),
                            'options' => ['prompt' => Yii::t('art/event', 'Select Event...'), 'id' => 'item_programm_id'],
                            'pluginOptions' => [
                                'depends' => ['programm_id'],
                                'placeholder' => Yii::t('art/event', 'Select Event...'),
                                'url' => Url::to(['/event/schedule/item'])
                            ]
                        ])->label(Yii::t('art/event', 'Event Name'));
                        
                        ?>
                    <?= $form->field($model, 'description')->widget(TinyMce::className()); ?>

                </div>

            </div>
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
                    
                   
                        <?=  $form->field($model, 'place_id')
                            ->dropDownList(backend\modules\event\models\EventPlace::getPlacesList(), [
                                'prompt' => Yii::t('art/event', 'Select Places...')
                            ])->label(Yii::t('art/event', 'Place Name'));
                        ?>
                        
                        <?= $form->field($model, 'start_time')->widget(kartik\datetime\DateTimePicker::classname())->widget(\yii\widgets\MaskedInput::className(), ['mask' => Yii::$app->settings->get('reading.date_time_mask')])->textInput(); ?>

                        <?= $form->field($model, 'end_time')->widget(kartik\datetime\DateTimePicker::classname())->widget(\yii\widgets\MaskedInput::className(), ['mask' => Yii::$app->settings->get('reading.date_time_mask')])->textInput() ?>
                        
                        <?= $form->field($model, 'users_list')->widget(kartik\select2\Select2::className(), [
                        'data' => backend\modules\event\models\EventSchedule::getScheduleUsersList(),
                        'options' => ['placeholder' => Yii::t('art/event', 'Select Users...'), 'multiple' => true],                        
                         ])
                        ?>
                   
                        <div class="form-group">
                            <?php if ($model->isNewRecord): ?>
                                <?= Html::submitButton(Yii::t('art', 'Create'), ['class' => 'btn btn-primary']) ?>
                                <?= Html::a(Yii::t('art', 'Cancel'), ['/event/schedule/index'], ['class' => 'btn btn-default']) ?>
                            <?php else: ?>                            

                            <div class="form-group clearfix">
                                <label class="control-label" style="float: left; padding-right: 5px;"><?= $model->attributeLabels()['id'] ?>: </label>
                                <span><?= $model->id ?></span>
                            </div>
                                <?= Html::submitButton(Yii::t('art', 'Save'), ['class' => 'btn btn-primary']) ?>
                                <?= Html::a(Yii::t('art', 'Delete'), ['/event/schedule/delete', 'id' => $model->id], [
                                    'class' => 'btn btn-default',
                                    'data' => [
                                        'confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
                                        'method' => 'post',
                                    ],
                                ])
                                ?>
<?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

<?php ActiveForm::end(); ?>

</div>
