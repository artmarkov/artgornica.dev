<?php

/* @var $this yii\web\View */

use yii\helpers\Html;

?>
<div id="user-schedule">     
         
         <?= \frontend\widgets\ScheduleUserWidget::widget(['model' => $model, 'pagination' => $pagination]); ?>

</div>

<!--        модал просмотра события пользователя -->
    <?php \yii\bootstrap\Modal::begin([
        'header' => '<h4 class="modal-title" id="eventModalLabel">' . Yii::t('art/event', 'View Event') . '</h4>',
        'size' => 'modal-lg',
        'id' => 'event-modal',
        'footer' => '<button class="btn btn-default" data-dismiss="modal">Close</button>'
        . '<button class="btn btn-primary">Save changes</button>',
    ]);

    \yii\bootstrap\Modal::end(); ?>
