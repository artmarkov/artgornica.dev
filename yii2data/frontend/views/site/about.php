<?php
/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\widgets\Breadcrumbs;
use artsoft\portfolio\models\Menu;
use artsoft\portfolio\models\Items;
use artsoft\block\models\Block;


$this->title = 'Обо мне';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-about">
    <section id="about" class="container">
        <!-- Who Am I -->
        <article class="row">
            <div class="col-md-6">
                <?php if($carousel['model_name'] != NULL) :?>
                <?= \frontend\widgets\CarouselWidget::widget(
                   [
                       'content_items' => \artsoft\mediamanager\models\MediaManager::getMediaList($carousel['model_name'], $carousel['id']),
                       'owl_options' => $carousel,
                       'options' => 
                            [
                                'type' => 'images',
                                'size' => 'medium',
                                'class' => 'owl-carousel text-center controlls-over',
                            ],
                   ]); 
                ?>
                <?php endif; ?>
            </div>
            <div class="col-md-6">

                <?= Block::getHtml('who-am-i'); ?>

                <hr />
            </div>
        </article>
        <article class="row">
            <div class="col-md-12">

                <?= Block::getHtml('about-me'); ?>

            </div>
        </article>
        <!-- /Who Am I -->

        <div class="divider styleColor"><!-- divider -->
            <i class="fa fa-heart"></i>
        </div>

        <!-- CALLOUT -->
        <section class="container">

            <div class="bs-callout text-center nomargin-bottom">
                <h3><?= Block::getHtml('davajte-razvivatsa-vmeste'); ?> <a href="<?= \yii\helpers\Url::to('/contact') ?>" class="btn btn-primary btn-lg">Свяжитесь со мной</a></h3>
            </div>

        </section>
        <!-- /CALLOUT -->

    </section>
</div>
