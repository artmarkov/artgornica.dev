<?php
/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\widgets\LinkPager;
use frontend\modules\sliderrevolution\SliderRevolution;
use frontend\widgets\CarouselWidget;


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
        <h1 class="text-center">
            <strong>Добро пожаловать</strong> в студию Елены Ишановой "Артгорница"
        </h1>

        <h2 class="text-center">30 ВСТРЕЧ - ПУТЬ К ПОИСКУ СЕБЯ!</h2>

        <div class="divider styleColor"><!-- divider -->
            <i class="fa fa-leaf"></i>
        </div>

        <p class="lead">Курс <a href="">"30 встреч"</a> помогает познать себя и окружающий мир, раскрыть в себе новые способности,
            не бояться изменять свою жизнь, осознать свою способность быть счастливым и делиться этим счастьем с
            другими!
        </p>
        
    </section>
    <!-- /WELCOME -->

        <div class="divider"></div><!-- divider -->
        
    <!-- Positive -->
    <section class="container">
        <div class="container">
            <div class="row">

                <div class="col-md-6 padding50 nopadding-top">
                    <h2>
                        <strong class="styleColor">Для кого </strong>Этот курс? 
                    </h2>	
                    <ul class="list-icon star-o color">
                        <li>Вы хотите заниматься тем, что доставляет удовольствие и быть счастливым, но Вы не решаетесь сделать шаг навстречу своим желаниям и мечтам?</li>
                        <li>Начните сейчас жить, не цепляясь за старое и страшась перемен! </li>
                        <li>Впустите в свою жизнь радость!</li>
                        <li>Почувствуйте себя, свой внутренний мир, свои ценности! </li>
                        <li>Поверьте в свои способности! Цените свое время! Познавайте новое! </li>
                        <li>Создайте намерение, цель, свою мечту!</li>
                        <li>Зажгите в себе энергию и направьте ее на что-то важное, следуйте за своей мечтой!</li>
                    </ul>
                    <?= Html::a('<i class="fa fa-chevron-circle-right"></i>' . Yii::t('art/section', 'Sign up for class') . '</span>', ["/site/contact"], ['class' => 'btn btn-primary btn-lg']) ?>

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
                    <h2>
                        <strong class="styleColor">Это </strong>Интересно
                    </h2>
                    <p class="lead">Приглашаю Вас посетить мой Блог, где Вы найдете много интересных и занимательных статей.
                    </p>
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
            <h2><strong>Ближайшие</strong> Занятия</h2>
            
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

                    <h2>Формат работы студии <strong>Артгорница</strong></h2>

                    <p class="lead">Перед тем как заключить договор мы с Вами встречаемся на один час, 
                        чтобы понять Ваш волнующий вопрос и насколько мы подходим друг другу. 
                        Эта первая встреча бесплатно.</p>
                    <hr />


                    <h2><strong>Варианты</strong> дальнейшей работы:</h2>

                    <!-- SERVICE 1 -->
                    <div class="row margin-top30">

                        <!-- SERVICE 1 -->
                        <div class="col-md-2 text-center margin-bottom20">
                            <i class="nomargin featured-icon fa fa-heart-o"></i>
                        </div>

                        <div class="col-md-10">
                            <h3><strong>Индивидуальное</strong> консультирование</h3>
                            <p>Для индивидуального консультирования разработан авторский курс 
                                «30 встреч» - Путь к поиску себя! 
                            </p>
                            <p>Курс "30 встреч" помогает познать себя и окружающий мир, раскрыть в себе новые способности, 
                                не бояться изменять свою жизнь, осознать свою способность быть счастливым и делиться этим счастьем с другими!</p>
                            <p>После заключения договора на авторский курс «30 встреч» мы с Вами встречаемся 2 раза в неделю в течение 4х месяцев. </p>
                            <?= Html::a('<i class="fa fa-sign-out"></i><span class="uppercase">' . Yii::t('art', 'Learn more...') . '</span>', ["/site/consult"], ['class' => 'btn btn-xs pull-right']) ?>

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
                            <h3>Психологическая работа в <strong>группе</strong></h3>
                            <p>Работа в группе из 6-7 участников проходит в формате от 2 до 10 встреч. </p>
                            <p>Темы и даты проведения занятий предварительно публикуются в Фейсбуке и Инстаграмме. 
                                Это могут быть темы: «Общество в миниатюре», «Мой внутренний мир», «Мой внутренний ребенок», 
                                «Эмоциональный интеллект», «Марафон прощания с обидами» и другие. </p>
                            <p>Вы сами выбираете интересующую Вас тему. </p>
                            <p>Вы записываетесь на мероприятие по телефону или отправляете сообщение в месенджере или на сайте.</p>
                            <?= Html::a('<i class="fa fa-sign-out"></i><span class="uppercase">' . Yii::t('art', 'Learn more...') . '</span>', ["/site/author-course"], ['class' => 'btn btn-xs pull-right']) ?>

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
                    <h3>Наши занятия <strong>помогают</strong>:</h3>
                    <ul class="list-icon star-o color">
                        <li>Отпустить эмоциональные переживания из прошлого и настоящего, тревогу за будущее.</li>
                        <li>Освободившуюся энергию направить на раскрытие потенциальных возможностей</li>
                        <li>Осознать свои мысли и эмоции</li>
                        <li>Выработать умение контролировать себя, свои чувства и переживания</li>
                        <li>Находить радостные моменты в любом событии Вашей жизни, даже кажущемся отрицательным</li>
                        <li>Выработать привычку – «Быть счастливым!»</li>
                    </ul>
                </div>

                <div class="col-md-6">
                    <h3>Что о нас говорят <strong>клиенты</strong>?</h3>
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
                        <?= Html::a('<i class="fa fa-sign-out"></i><span class="uppercase">' . Yii::t('art', 'Leave a review...') . '</span>', ["/site/contact"], ['class' => 'btn btn-xs pull-right']) ?>
                       

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
            <h3>Записаться на <strong>бесплатную</strong> консультацию! 
                
                <?= Html::a('<i class="fa fa-chevron-circle-right"></i>' . Yii::t('art', 'Sign up...') . '</span>', ["/site/contact"], ['class' => 'btn btn-primary btn-lg']) ?>
                       
               </h3>
        </div>

    </section>
    <!-- /CALLOUT -->
</div>