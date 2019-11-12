
<?php if (!$model->isNewRecord) : ?>
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    <?= backend\modules\event\widgets\ItemProgrammWidget::widget(['model' => $model]); ?>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>


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