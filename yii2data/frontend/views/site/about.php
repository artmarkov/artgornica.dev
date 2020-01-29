<?php
/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\widgets\Breadcrumbs;
use artsoft\portfolio\models\Menu;
use artsoft\portfolio\models\Items;


$this->title = Yii::t('art', 'About');
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
                <h4><i class="fa fa-heart-o"></i> Кто Я?</h4>
                <p>Елена Ишанова - основатель и руководитель Студии «Арт-Горница», 
                    психолог, арт-терапевт, коуч по программе «Путь к поиску Себя!»</p>
                <h4><i class="fa fa-heart-o"></i> Направление деятельности:</h4>
                <p>Психологическое консультирование индивидуально и в группе, 
                    с применением методов арт-терапии.</p>
                <h4><i class="fa fa-heart-o"></i> Мои творческие увлечения:</h4>
                <ul class="list-icon heart-o color">
                    <li>Рисунок в студии живописи и рисунка «Пушкин»</li>
                    <li>Курс «Иконопись» в  мастерской возрождения творчества</li>
                    <li>Курс «Каллиграфия» в национальной школе «Искусство красивого письма»</li>
                </ul>
                <hr />
            </div>
        </article>
        <article class="row">
            <div class="col-md-12">
                <h4><i class="fa fa-heart-o"></i> Образование:</h4>
                <p>Психологическое образование - Институт интенционально-синергетической психологии (ИИСП), 
                    специальность психолог арт-терапевт. </p>
                <h4><i class="fa fa-heart-o"></i> Опыт работы:</h4>
                <p>Закончив по первому образованию Экономический институт с красным дипломом, 
                    успешно работала в Банке и доросла в должности от Экономиста до Начальника отдела Ликвидности, 
                    получив второе Психологическое образование и оставив финансово-экономическую сферу деятельности, 
                    организовала Студию Елены Ишановой «Арт-Горница». Сейчас провожу психологические консультации и тренинги, и 
                    эффективно применяю самостоятельно разработанный мной курс «30 встреч» - Путь к поиску Себя!</p>
                <h4><i class="fa fa-heart-o"></i> О себе:</h4>
                <p>Много путешествую, люблю познавать мир, интересуюсь окружающими меня людьми. 
                    Много общаюсь с друзьями, совместно выезжаю на мероприятия – на полеты в компании друзей парапланеристов. 
                    Люблю подниматься в горы. Люблю лес и люблю собирать грибы. Люблю смотреть на звезды, на облака и на воду. 
                    Люблю дождь, люблю солнце, люблю золотую осень и снег. Люблю рисовать и фотографировать. Люблю дело, которым занимаюсь. </p>               
                <h4><i class="fa fa-heart-o"></i> Каждый клиент – это целая книга!</h4>
                <p>Имея большой опыт взаимодействия с клиентами, внимательно слушаю человека и ответственно подхожу к каждой встрече. 
                    Мои профессиональные знания и опыт работы в психологии, а также в экономике помогают мне анализировать и подбирать такие техники арт-терапии, 
                    которые оптимально раскрывают тему занятия и отвечают на волнующие вопросы участников курса «30 встреч».</p>
               
            </div>
        </article>
        <!-- /Who Am I -->

        <div class="divider styleColor"><!-- divider -->
            <i class="fa fa-heart"></i>
        </div>
        
        <!-- CALLOUT -->
        <section class="container">

            <div class="bs-callout text-center nomargin-bottom">
                <h3>Давайте развиваться <strong>вместе</strong>! <a href="<?= \yii\helpers\Url::to('/contact') ?>" class="btn btn-primary btn-lg">Свяжитесь со мной</a></h3>
            </div>

        </section>
        <!-- /CALLOUT -->

    </section>


</div>
