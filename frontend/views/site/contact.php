<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\Contact */

use artsoft\widgets\ActiveForm;
use yii\helpers\Html;
use yii\captcha\Captcha;
use kartik\switchinput\SwitchInput;

$this->title = Yii::t('art', 'Contact');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-contact">
    <section id="contact" class="container">
        <h2><strong><em>Напишите мне.</em></strong> Я обязательно свяжусь с Вами!</h2>

        <?php $form = ActiveForm::begin(['id' => 'contact-form']); ?>

        <div class="row">
            <div class="col-md-6">
                <?= $form->field($model, 'name') ?>
            </div>
            <div class="col-md-6">
                <?= $form->field($model, 'email') ?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <?= $form->field($model, 'subject') ?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <?= $form->field($model, 'body')->textArea(['rows' => 6]) ?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                 <?= $form->field($model, 'verifyCode')->widget(Captcha::className(), [
                'template' => '<div class="row"><div class="col-lg-3">{image}</div><div class="col-lg-6">{input}</div></div>',
            ]) ?>
            </div>
            <div class="col-md-8">
                <?= $form->field($model->loadDefaultValues(), 'subscribe')->widget(SwitchInput::classname(), [
                                'pluginOptions' => [
                                    'size' => 'small',
                                ],
                            ])->label(Yii::t('art', 'Subscribe to news')); ?>
            </div>
        </div>
        <div class="row pull-right">
            <div class="col-md-12">
                <?= Html::submitButton('Отправить сообщение', ['class' => 'btn btn-primary btn-lg', 'name' => 'contact-button']) ?>
            </div>
        </div>

        <?php ActiveForm::end(); ?>

    </section>
</div>