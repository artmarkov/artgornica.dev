
<?php if (!$model->isNewRecord) : ?>
    <div class="row">
        <div class="col-md-12">
            <?= backend\modules\event\widgets\ItemProgrammWidget::widget(['model' => $model]); ?>
        </div>
    </div>
<?php endif; ?>


