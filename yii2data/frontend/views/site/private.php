<?php

$this->title = Yii::t('art/event', 'Private');
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="private">
    <section id="private" class="container">
        <div class="tabs nomargin-top container">
            <?= \yii\bootstrap\Tabs::widget([
                'encodeLabels' => false,
                'id' => 'user_private',
                'items' => [
                    [
                        'label' => '<i class="fa fa-cogs"></i> ' . Yii::t('art/auth', 'User Profile'),
                        'content' => $this->render('@frontend/modules/auth/views/default/profile', ['model' => $model_profile]),
                    ],
                    [
                        'label' => '<i class="fa fa-calendar"></i> ' . Yii::t('art/event', 'User Schedule'),
                        'content' => $this->render('@frontend/views/event/index', ['model' => $model, 'pagination' => $pagination]),
                    ],              
                ],
              ])
            ?>

        </div>
    </section>
</div>

<?php $this->registerJsFile('https://code.jquery.com/jquery-1.11.2.min.js', ['position' => \yii\web\View::POS_HEAD]) ?>
<?php
$js = <<<JS
        
$(document).ready(function(){
    $('a[data-toggle="tab"]').on('show.bs.tab', function(e) {
        localStorage.setItem('activeTab', $(e.target).attr('href'));
    });
    var activeTab = localStorage.getItem('activeTab');
    if(activeTab){
        $('#user_private a[href="' + activeTab + '"]').tab('show');
    }
});

JS;

$this->registerJs($js, yii\web\View::POS_HEAD);
?>

