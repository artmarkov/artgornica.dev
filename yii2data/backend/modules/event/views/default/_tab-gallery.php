<?php if (!$model->isNewRecord) : ?>
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-body">

                    <?= \artsoft\mediamanager\widgets\MediaManagerWidget::widget(['model' => $model]); ?>

                </div> 
            </div>
        </div>
    </div>

<?php endif; ?>

