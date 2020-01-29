<?php
/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\widgets\Breadcrumbs;
use artsoft\portfolio\models\Menu;
use artsoft\portfolio\models\Items;


$this->title = Yii::t('art/section','Portfolio Items');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-portfolio">
    <section id="portfolio">     
            <div class="container">

                <h2><strong>Добро пожаловать</strong> в мою фотогалерею</h2>

                <p class="lead">В фотогалерее представлены фотографии моих работ и работ моих клиентов. 
                    Также здесь Вы можете познакомиться поближе <a href=""></a>
                    с Арттерапией. Здесь Вы найдете много видео и фото с наших занятий.</p>

               
                    <?php 

                    echo yii\widgets\Menu::widget([
                        'encodeLabels' => false,
                        'options' => [
                            'class' => 'nav nav-pills isotope-filter isotope-filter', 
                            'data-sort-id' => 'isotope-list', 
                            'data-option-key' => 'filter'
                            ],
                        'items' => Menu::getPortfolioMenuItems(),
                    ]);
                    
                    echo frontend\widgets\PortfolioWidget::widget([                        
                        'slides' => Items::getPortfolioMasonryItems(),
                    ]);
                    ?>
      
        <div class="divider styleColor"><!-- divider -->
            <i class="fa fa-leaf"></i>
        </div>
        <!-- CALLOUT -->
        <section class="container">

            <div class="bs-callout text-center nomargin-bottom">
                <h3>Давайте развиваться <strong>вместе</strong>! <a href="<?= \yii\helpers\Url::to('/contact') ?>" class="btn btn-primary btn-lg">Свяжитесь со мной</a></h3>
            </div>

        </section>
        <!-- /CALLOUT -->

            </div>
    </section>


</div>
