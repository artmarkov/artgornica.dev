<?php

namespace frontend\widgets;

use yii\base\Widget;

/**
 * Description of ParallaxWidget
 *
 * @author artmarkov
 */
class ParallaxWidget extends Widget {

    public $parallax;

    public function run() {

        return $this->render('parallax', [
                    'parallax' => $this->parallax
        ]);
    }

}

