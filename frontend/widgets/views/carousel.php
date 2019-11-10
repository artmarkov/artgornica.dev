<?php
/* @var $this yii\web\View */

use yii\helpers\Html;
use artsoft\media\models\Media;
use frontend\widgets\owlcarousel\OwlCarouselWidget;

?>  
<?php if(!empty($owl_options)) : ?>
        <?php
//     echo '<pre>' . print_r($owl_options, true) . '</pre>';
        OwlCarouselWidget::begin([
            'container' => 'div',
            'containerOptions' => [
                'class' => $options['class'],
            ],
            'pluginOptions' => [
                'items' => $owl_options['items'],
                'singleItem' => $owl_options['single_item'] == 1 ? true : false,
                'navigation' => $owl_options['navigation'] == 1 ? true : false,
                'pagination' => $owl_options['pagination'] == 1 ? true : false,
                'transitionStyle' => $owl_options['transition_style'],
                'autoPlay' => count($content_items) != 1 ? $owl_options['auto_play'] : false,
            ]
        ]);
        ?>
       <?php 
       $content = '';
       
        if($options['type'] === 'images') {
            
            foreach ($content_items as $key => $item) :   
                $content .= Html::beginTag('div');
                $content .= Html::img(Media::findById($item['media_id'])->getThumbs()[$options['size']], ['class' => 'img-responsive', 'alt' => '']); 
                $content .= Html::endTag('div'); 
            endforeach;
        
        }
        elseif($options['type'] === 'text') { 
       
            foreach ($content_items as $key => $item) :   
                $content .= Html::beginTag('div',['class' => 'testimonial white']);
                $content .= $item['content'];
                $content .= Html::beginTag('cite');
                $content .= Html::tag('strong', $item['username']);           
                $content .= ', ' . $item['business'];
                $content .= Html::endTag('cite'); 
                $content .= Html::endTag('div'); 

            endforeach;
            
        }
        elseif ($options['type'] === 'event')
    {

        foreach ($content_items as $key => $item) :
            $content .= $this->render('/event/event-index.php', ['event' => $item]);
        endforeach;
    }

    echo $content;
    ?>

         <?php OwlCarouselWidget::end(); ?>
<?php endif; ?>