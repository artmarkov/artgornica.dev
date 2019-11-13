<?php

use artsoft\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\event\models\EventProgramm */
/* @var $form artsoft\widgets\ActiveForm */

$form = ActiveForm::begin([
            'id' => 'event-programm-form',
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
                    'label' => '<i class="fa fa-save"></i> ' . Yii::t('art/event', 'Save'),
                    'content' => $this->render('@backend/modules/event/views/programm/_tab-main', ['model' => $model, 'form' => $form]),
                ],
                [
                    'label' => '<i class="fa fa-list"></i> ' . Yii::t('art/event', 'Event List'),
                    'content' => $this->render('@backend/modules/event/views/programm/_tab-programm', ['model' => $model]),
                    'visible' => !$model->isNewRecord,
                ],
                [
                    'label' => '<i class="fa fa-image"></i> ' . Yii::t('art/event', 'Album'),
                    'content' => $this->render('@backend/modules/event/views/programm/_tab-gallery', ['model' => $model]),
                    'visible' => !$model->isNewRecord,
                ],
            ],
        ])
        ?>
    </div>
</div>


<?php ActiveForm::end(); ?>
<!--        модал добавления занятия в программу-->
<?php
\yii\bootstrap\Modal::begin([
    'header' => '<h3 class="lte-hide-title page-title">' . Yii::t('art/event', 'Events') . '</h3>',
    // 'size' => 'modal-sm',
    'id' => 'item-programm-modal',
        //'footer' => 'footer',
]);

\yii\bootstrap\Modal::end();
?>

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