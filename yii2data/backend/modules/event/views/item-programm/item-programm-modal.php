<?php

use artsoft\widgets\ActiveForm;
use artsoft\helpers\Html;

/* @var $model backend\modules\event\models\EventItemProgramm */
/* @var $form artsoft\widgets\ActiveForm */

?>

<div class="item-programm-form">
    <?php if ($model->isNewRecord) {
        $action = 'create-programm';
    } else {
        $action = 'update-programm';
    }
    ?>
    <?php $form = ActiveForm::begin([
    'id' => 'item-programm-form',
        
    'enableAjaxValidation' => true,
    'action' => ['item-programm/' . $action , 'id' => $model->id]
]);
    ?>

    <div class="row">
        <div class="col-md-12">
            <div class="form-group clearfix">
                <label class="control-label" style="float: left; padding-right: 5px;">
                    <?= $model->attributeLabels()['itemName'] ?> :
                </label>
                <span><?= $model->itemName ?></span>
            </div>
            
            <div class="row">
                <div class="col-md-12">
                    <?= $form->field($model, 'name_short')->textInput() ?>
                </div>
<!--                <div class="col-md-6">
                     <?= $form->field($model, 'price')->textInput() ?>                    
                </div>-->
                <div class="col-md-12">
                    
                     <?= $form->field($model, 'practice_list')->widget(kartik\select2\Select2::className(), [
                            'data' => backend\modules\event\models\EventPractice::getEventPracticeByName($model->item_id),
                            'options' => [
                                'placeholder' => Yii::t('art/event', 'Select Practice...'), 
                                'multiple' => true
                            ],                              
                        ])
                        ?>
                </div>
            </div>

            <?= $form->field($model, 'programm_id')->label(false)->hiddenInput() ?>
            
            <?= $form->field($model, 'item_id')->label(false)->hiddenInput() ?>

            <?php if ($model->isNewRecord) {
                echo Html::submitButton(Yii::t('art', 'Add'), ['class' => 'btn btn-primary']);
            } else {
                echo Html::submitButton(Yii::t('art', 'Update'), ['class' => 'btn btn-primary']);
            }
            ?>

        </div>
    </div>

<?php ActiveForm::end(); ?>

</div>
