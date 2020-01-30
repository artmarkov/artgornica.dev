<?php
/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\widgets\Breadcrumbs;
use artsoft\portfolio\models\Menu;
use artsoft\portfolio\models\Items;
use artsoft\block\models\Block;

$this->title = Yii::t('art/section','Portfolio Items');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-portfolio">
    <section id="portfolio">     
            <div class="container">

                <?= Block::getHtml('dobro-pozalovat-v-mou-fotogalereu'); ?>
               
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
                <h3><?= Block::getHtml('davajte-razvivatsa-vmeste'); ?> <a href="<?= \yii\helpers\Url::to('/contact') ?>" class="btn btn-primary btn-lg">Свяжитесь со мной</a></h3>
            </div>

        </section>
        <!-- /CALLOUT -->

            </div>
    </section>


</div>
