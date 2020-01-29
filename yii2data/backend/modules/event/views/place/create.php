<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\event\models\EventPlace */

$this->title = Yii::t('art','Create');
$this->params['breadcrumbs'][] = ['label' => Yii::t('art/event','Events'), 'url' => ['default/index']];
$this->params['breadcrumbs'][] = ['label' => Yii::t('art/event','Event Places'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="event-place-create">
    <h3 class="lte-hide-title"><?=  Html::encode($this->title) ?></h3>
    <?=  $this->render('_form', compact('model')) ?>
</div>