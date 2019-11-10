<?php

namespace frontend\widgets;

use yii\base\Widget;

/**
 * Description of CarouselWidget
 *
 * @author artmarkov
 */
class CarouselWidget extends Widget {

    public $owl_options;
    public $options;
    public $content_items;

    public function run() {

        return $this->render('carousel', [
                    'owl_options' => $this->owl_options,
                    'options' => $this->options,
                    'content_items' => $this->content_items,
        ]);
    }

}

