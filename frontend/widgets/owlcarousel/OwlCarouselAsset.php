<?php

/**
 * @link      https://github.com/kv4nt/yii2-owl-carousel2
 * @license   https://github.com/kv4nt/yii2-owl-carousel2/blob/master/LICENSE.md
 */

namespace frontend\widgets\owlcarousel;

use yii\web\AssetBundle;

/**
 * Asset Bundle for Owl Carousel Widget
 *
 * @author Victor Shumeyko <kvant90@gmail.com>
 */
class OwlCarouselAsset extends AssetBundle
{

    /**
     * @var string the directory that contains the source asset files for this asset bundle.
     */
    public $sourcePath = '@frontend/web/plugins/owl-carousel';

    /**
     * @var array list of CSS files that this bundle contains.
     */
    public $css = [
        'owl.carousel.css',
        'owl.theme.css',
        'owl.transitions.css',
    ];

    /**
     * @var array list of JavaScript files that this bundle contains.
     */
    public $js = [
        'owl.carousel.min.js',
    ];

    /**
     * @var array list of depends assets that this bundle contains.
     */
    public $depends = [
        'yii\web\JqueryAsset',
    ];

}
