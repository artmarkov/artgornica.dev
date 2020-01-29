<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\event\models\EventItem */

$this->title = Yii::t('art','Update'). ': ' . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('art/event','Events'), 'url' => ['index']];
$this->params['breadcrumbs'][] = Yii::t('art','Update');
?>
<div class="event-item-update">
    <h3 class="lte-hide-title"><?= Html::encode($this->title) ?></h3>
    <?= $this->render('_form', compact('model')) ?>
</div>