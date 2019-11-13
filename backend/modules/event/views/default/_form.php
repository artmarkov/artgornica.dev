<?php

use artsoft\widgets\ActiveForm;

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

<div class="event-programm-form">
    <div class="tabs nomargin-top">

        <?= \yii\bootstrap\Tabs::widget([
            'encodeLabels' => false,
            'id' => 'tabs_event',
            'items' => [
                [
                    'label' => '<i class="fa fa-pencil-square-o"></i> ' . Yii::t('art/event', 'Main'),
                    'content' => $this->render('@backend/modules/event/views/default/_tab-main', ['model' => $model, 'form' => $form]),
                ],
                [
                    'label' => '<i class="fa fa-briefcase"></i> ' . Yii::t('art/default', 'Practice'),
                    'content' => $this->render('@backend/modules/event/views/default/_tab-practice', ['model' => $model]),
                    'visible' => !$model->isNewRecord,
                ],
                [
                    'label' => '<i class="fa fa-image"></i> ' . Yii::t('art/default', 'Album'),
                    'content' => $this->render('@backend/modules/event/views/default/_tab-gallery', ['model' => $model]),
                    'visible' => !$model->isNewRecord,
                ],
            ],
        ])
        ?>
    </div>
</div>


<?php ActiveForm::end(); ?>

<?php $this->registerJsFile('https://code.jquery.com/jquery-1.11.2.min.js', ['position' => \yii\web\View::POS_HEAD]) ?>

<?php
$js = <<<JS
        
$(document).ready(function(){
    $('a[data-toggle="tab"]').on('show.bs.tab', function(e) {
        localStorage.setItem('activeTab', $(e.target).attr('href'));
    });
    var activeTab = localStorage.getItem('activeTab');
    if(activeTab){
        $('#tabs_event a[href="' + activeTab + '"]').tab('show');
    }
});

JS;

$this->registerJs($js, yii\web\View::POS_HEAD);
?>