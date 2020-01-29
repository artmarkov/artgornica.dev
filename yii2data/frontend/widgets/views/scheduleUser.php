<?php

use artsoft\widgets\ActiveForm;
use artsoft\helpers\Html;
use kartik\select2\Select2;
?>
<?php $form = ActiveForm::begin(); ?>

<div class="schedule-widget">
    <div class="row">

        <?php //echo '<pre>' . print_r($model, true) . '</pre>';  ?>

        <div class="table-responsive">
            <table class="table table-hover table-striped">
                <!-- table head -->
                <thead>
                    <tr>
                        <th>#</th>
                        <th><?= Yii::t('art/event', 'Programm Name'); ?></th>
                        <th><?= Yii::t('art/event', 'Event Name'); ?></th>
                        <th><?= Yii::t('art/event', 'Place Name'); ?></th>
                        <th><?= Yii::t('art/event', 'Start Time'); ?></th>
                        <th><?= Yii::t('art/event', 'End Time'); ?></th>
                        <th></th>
                    </tr>
                </thead>

                <!-- table items -->
                <tbody>
                    <?php foreach ($model as $id => $item): ?>
                        <tr><!-- item -->
                            <td><?= ++$id ?></td>
                            <td><?= $item['programmName'] ?></td>
                            <td><?= $item['itemName'] ?></td>
                            <td><?= $item['placeName'] ?></td>
                            <td><?= $item['start_time'] ?></td>
                            <td><?= $item['end_time'] ?></td>
                            <td><?= Html::a('<span class="glyphicon glyphicon-eye-open text-color-default" aria-hidden="true"></span>', ['#'], [
                                        'class' => 'view-event',
                                        'data-id' => $item['id'],
                                    ]);
                                    ?>
                                <?= Html::a('<span class="glyphicon glyphicon-eye-open text-color-default" aria-hidden="true"></span>', 
                                        ['/event/private', 'id' => $item['id']]); ?>
                                    
                            </td>
                        </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
        </div>

        <!-- PAGINATION -->
        <div class="text-center">
            <?= yii\widgets\LinkPager::widget(['pagination' => $pagination]) ?>
        </div>

    </div>
</div>


<?php ActiveForm::end(); ?>

<?php
$js = <<<JS

function showEvent(author) {
    $('#event-modal .modal-body').html(author);
    $('#event-modal').modal();
}

$('.view-event').on('click', function (e) {

    e.preventDefault();

    var id = $(this).data('id');

    $.ajax({
        url: '/event/view-event',
        data: {id: id},
        type: 'GET',
        success: function (res) {
            if (!res)  alert('Error!');
           // console.log(res);
           else showEvent(res);
        },
        error: function () {
            alert('Error!');
        }
    });
});

JS;

$this->registerJs($js);
?>