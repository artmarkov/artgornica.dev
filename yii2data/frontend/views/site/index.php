<?php
/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\widgets\LinkPager;
use frontend\modules\sliderrevolution\SliderRevolution;
use frontend\widgets\CarouselWidget;
use artsoft\block\models\Block;


?>
<div class="site-index">
   
    <!-- REVOLUTION SLIDER -->
     
<?= SliderRevolution::widget([
    'config' => ['delay' => 9000, 'startwidth' => 1170, 'startheight' => 500, 'hideThumbs' => 200, 'fullWidth' => '"on"', 'forceFullWidth' => '"off"'],
    'container' => ['class' => 'fullwidthbanner-container roundedcorners'],
    'wrapper' => ['class' => 'fullwidthbanner'],
    'ulOptions' => [],
    'slides' => \artsoft\slides\models\Slides::getSlidesData(),
]);

?>
   
    <!-- /REVOLUTION SLIDER -->
    
    <!-- WELCEOME -->
    <section id = "welcome" class="container">
        <?= Block::getHtml('welcome'); ?>
    </section>
    <!-- /WELCOME -->

        <div class="divider"></div><!-- divider -->

    <!-- Positive -->
    <section class="container">
        <div class="container">
            <div class="row">

                <div class="col-md-6 padding50 nopadding-top">
                    <?= Block::getHtml('dla-kogo-etot-kurs'); ?>
                    <?= Html::a('<i class="fa fa-chevron-circle-right"></i> Запишитесь на занятия</span>', ["/site/contact"], ['class' => 'btn btn-primary btn-lg']) ?>
                </div>

                <div class="col-md-6">
                    <?php if($carousel['model_name'] != NULL) :?>
                    <?= CarouselWidget::widget(
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
            </div>
    </section>
    <!-- /Positive -->

    <div class="divider"><!-- divider -->
        <i class="fa fa-leaf"></i>
    </div>

    <!-- POST -->
    <section id = "post" class="container padding50 nopadding-top">
        <div class="container">
            <div class="row">
                <div class="col-md-12">

                    <?= Block::getHtml('eto-interesno'); ?>

                    <div class="row text-center">
                        <?php foreach ($posts as $post) : ?>

                            <?= $this->render('/items/post-index.php', ['post' => $post]) ?>

                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- /POST -->

    <!-- PARALLAX -->
     <?= \frontend\widgets\ParallaxWidget::widget(['parallax' => $parallax]); ?>
    <!-- PARALLAX -->

    <!-- PORTFOLIO -->
    <section id="portfolio" class="event special-row padding50">
        <div class="container">
            <?= Block::getHtml('blizajsie-zanatia'); ?>

            <?= CarouselWidget::widget(
                    [
                        'content_items' => backend\modules\event\models\EventSchedule::getEventScheduleList(),
                        'owl_options' => backend\modules\event\models\EventSchedule::getCarouselOption(),
                        'options' =>
                        [
                            'type' => 'event',
                            'class' => 'owl-carousel text-center',
                        ],
            ]);
            ?>
        </div>
    </section>
    <!-- /PORTFOLIO -->

    <!-- SERVICES -->
    <section class="margin-top50">
        <div class="container">

            <div class="row">
                <div class="col-md-12">

                    <?= Block::getHtml('format-raboty-studii-artgornica'); ?>

                    <hr />

                    <?= Block::getHtml('varianty-dalnejsej-raboty'); ?>

                    <!-- SERVICE 1 -->
                    <div class="row margin-top30">

                        <!-- SERVICE 1 -->
                        <div class="col-md-2 text-center margin-bottom20">
                            <i class="nomargin featured-icon fa fa-heart-o"></i>
                        </div>

                        <div class="col-md-10">

                            <?= Block::getHtml('individualnoe-konsultirovanie'); ?>

                            <?= Html::a('<i class="fa fa-sign-out"></i><span class="uppercase"> Узнать больше...</span>', ["/site/consult"], ['class' => 'btn btn-xs pull-right']) ?>

                        </div>

                    </div>

                    <div class="divider half-margins"><!-- divider -->
                        <i class="fa fa-plus-circle"></i>
                    </div>

                    <!-- SERVICE 2 -->
                    <div class="row margin-top30">

                        <div class="col-md-2 text-center margin-bottom20">
                            <i class="nomargin featured-icon fa fa-smile-o"></i>
                        </div>

                        <div class="col-md-10">

                            <?= Block::getHtml('psihologiceskaa-rabota-v-gruppe'); ?>
                            <?= Html::a('<i class="fa fa-sign-out"></i><span class="uppercase"> Узнать больше...</span>', ["/site/author-course"], ['class' => 'btn btn-xs pull-right']) ?>

                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- /SERVICES -->
    <div class="divider  styleColor"><!-- divider -->
        <i class="fa fa-leaf"></i>
    </div>
    <!--TESTIONARS-->
    <section id="testionars"  class="padding50 margin-footer">
        <div class="container">
            <div class="row">
                <div class="col-md-6">

                    <?= Block::getHtml('nasi-zanatia-pomogaut'); ?>

                </div>

                <div class="col-md-6">

                    <?= Block::getHtml('cto-o-nas-govorat-klienty'); ?>

                <!-- transitionStyle: fade, backSlide, goDown, fadeUp,  -->

                     <?=  CarouselWidget::widget(
                            [
                                'content_items' => artsoft\feedback\models\Feedback::getFeedbackList(),
                                'owl_options' => artsoft\feedback\models\Feedback::getCarouselOption(),
                                'options' =>
                                [
                                    'type' => 'text',
                                    'class' => 'owl-carousel text-center',
                                ],
                    ]);
                    ?>

                    <div class="row text-center nomargin-bottom">
                        <?= Html::a('<i class="fa fa-sign-out"></i>
                            <span class="uppercase"> Оставьте отзыв...</span>',
                            ["/site/contact"], ['class' => 'btn btn-xs pull-right'])
                        ?>

                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--/TESTIONARS-->

    <div class="divider"><!-- divider -->
        <i class="fa fa-leaf"></i>
    </div>

    <!-- CALLOUT -->
    <section class="container">

        <div class="bs-callout special-row text-center nomargin">

                    <?= Block::getHtml('zapisatsa-na-besplatnuu-konsultaciu'); ?>

                <?= Html::a('<i class="fa fa-chevron-circle-right"></i> Напишите мне...</span>', ["/site/contact"], ['class' => 'btn btn-primary btn-lg']) ?>
                       
               </h3>
        </div>

    </section>
    <!-- /CALLOUT -->
</div>