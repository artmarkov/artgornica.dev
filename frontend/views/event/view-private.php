<?php

use yii\helpers\ArrayHelper;

/* @var $model artsoft\event\models\EventItemProgramm */
/* @var $form artsoft\widgets\ActiveForm */

$this->title = $model->itemName;
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="event-view">
    <section id="about" class="container">
    
<?php //echo '<pre>' . print_r($model->place, true) . '</pre>'; ?>
    
    <article class="row">
             <div class="col-md-6">
                 <!-- carousel -->
    
                <?= \frontend\widgets\CarouselWidget::widget(
                        [
                            'content_items' => \artsoft\mediamanager\models\MediaManager::getMediaList($model->item->className(), $model->item->id),
                            'owl_options' => $model->item->getCarouselOption(),
                            'options' =>
                            [
                                'type' => 'images',
                                'size' => 'medium',
                                'class' => 'owl-carousel controlls-over',
                            ],
                ]);
                ?>
                <!-- carousel -->
             </div>
             <div class="col-md-6">
                 <h4><i class="fa fa-heart-o"></i> <?= Yii::t('art/event', 'Event Name'); ?>:</h4>
                 <p><?= $model->itemName ?></p>
                 <h4><i class="fa fa-heart-o"></i> <?= Yii::t('art/event', 'Schedule Description'); ?>:</h4>
                 <p><?= $model->description ?></p>
                 <h4><i class="fa fa-heart-o"></i> <?= Yii::t('art/event', 'Event Description'); ?>:</h4>
                 <p><?= $model->itemDescription ?></p>
                 <h4><i class="fa fa-heart-o"></i> <?= Yii::t('art/event', 'Start Time'); ?>:</h4>
                 <p><?= $model->start_time ?></p>
                 <h4><i class="fa fa-heart-o"></i> <?= Yii::t('art/event', 'End Time'); ?>:</h4>
                 <p><?= $model->end_time ?></p>
                
                 
                 <hr />
             </div>
         </article>
        <article class="row">
            <div class="col-md-6">
                 <h4><i class="fa fa-heart-o"></i> <?= Yii::t('art/event', 'Programm Name'); ?>:</h4>
                 <p><?= $model->programmName ?></p>
                 <h4><i class="fa fa-heart-o"></i> <?= Yii::t('art/event', 'Programm Description'); ?>:</h4>
                 <p><?= $model->programmDescription ?></p>
                 <h4><i class="fa fa-heart-o"></i>  <?= Yii::t('art/event', 'Practice List'); ?>:</h4>
                    <ul class="list-icon heart-o color">
                     <?php foreach ($model->item->eventPractices as $data): ?>                        
                        <li><?= $data->name ?></li>
                     <?php endforeach ?>
                    </ul>
            </div>
            <div class="col-md-6">
                 <h4><i class="fa fa-heart-o"></i> <?= Yii::t('art/event', 'Place Name'); ?>:</h4>
                 <p><?= $model->place->name ?></p>
                 <h4><i class="fa fa-heart-o"></i> <?= Yii::t('art', 'Address'); ?>:</h4>
                 <p><?= $model->place->address ?></p>
                 <h4><i class="fa fa-heart-o"></i> <?= Yii::t('art', 'Phone'); ?>:</h4>
                 <p><?= $model->place->phone ?></p>
                 <h4><i class="fa fa-heart-o"></i> <?= Yii::t('art', 'Email'); ?>:</h4>
                 <p><?= $model->place->email ?></p>
                 <h4><i class="fa fa-heart-o"></i> <?= Yii::t('art', 'Contact Person'); ?>:</h4>
                 <p><?= $model->place->сontact_person ?></p>
                 
            </div>
        </article>
        
        <article class="row">
            <div class="col-md-12">
                 <?=  common\widgets\YandexDisplayMapWidget::widget([
                                'center' => $model->place->coords,
                                'zoom' => $model->place->map_zoom,
                            ]); ?>
            </div>
        </article>

</section>
</div>