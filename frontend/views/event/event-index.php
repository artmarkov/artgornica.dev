<?php

use yii\helpers\Html;

/* @var $event artsoft\post\models\EventSchedule */
?>
<!-- item -->

<div class="item-box appear-animation pull-left inner" data-animation="fadeInDown">
    <figure>                            
        <?= Html::a('<span class="overlay color2"></span><span class="inner">
            <span class="block fa fa-plus fsize20"></span>
            <span class="uppercase"><strong>детали</strong> занятия</span>', ['/event/view', 'id' => $event->id], ['class' => 'item-hover']);
        ?>
        <?php
        $item = \artsoft\mediamanager\models\MediaManager::getMediaFirst($event->item->className(), $event->item_id);
        if (!empty($item))
            echo Html::img(\artsoft\media\models\Media::findById($item['media_id'])->getThumbs()['medium'], ['class' => 'img-responsive', 'alt' => '']);
        else
            echo Html::img('/images/noimg.png', ['class' => 'img-responsive', 'alt' => '']);
        ?>
    </figure>
    <div class="item-box-desc">
        <h4><span class="uppercase"><?= $event->itemName ?></span></h4>
            <?= Html::a('<i class="fa fa-sign-out"></i><span class="">' . $event->startDate . '</span>', ['/event/view', 'id' => $event->id], ['class' => 'btn btn-primary btn-lg']) ?>
    </div>
</div>

<!-- /item -->
