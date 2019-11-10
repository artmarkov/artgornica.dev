<?php

/**
 * @link      https://github.com/kv4nt/yii2-owl-carousel2
 * @license   https://github.com/kv4nt/yii2-owl-carousel2/blob/master/LICENSE.md
 */

namespace frontend\widgets\owlcarousel;

use yii\helpers\Html;

/**
 * Owl Carousel widget is a yii2 wrapper for Owl Carousel Plugin
 *
 * @author Victor Shumeyko <kvant90@gmail.com>
 * @see https://owlcarousel2.github.io/
 */
class OwlCarouselWidget extends \yii\base\Widget
{

    /**
     * @var string the widget container element
     * Defaults to div
     */
    public $container;

    /**
     * @var array the HTML attributes for the widget container
     * Defaults to an auto generated id and class => "owl-carousel"
     */
    public $containerOptions = [];

    /**
     * @var array options for the Owl Carousel plugin
     * @link https://owlcarousel2.github.io/OwlCarousel2/docs/api-options.html Available Options
     */
    public $pluginOptions = [];

    /**
     * Initializes the widget.
     *
     */
    public function init()
    {
        parent::init();
        if (!isset($this->container)):
            $this->container = 'div';
        endif;
        if (!is_array($this->containerOptions)):
            $this->containerOptions = [];
        endif;
        if (!is_array($this->pluginOptions)):
            $this->pluginOptions = [];
        endif;
     
        ob_start();
    }


    /**
     * Registers the needed assets.
     *
     * @param View $view The View object
     */
    public function registerAssets($view)
    {
        OwlCarouselAsset::register($view);
      
    }

    /**
     * Executes the widget.
     * @return string the result of widget execution to be outputted.
     */
    public function run()
    {
        $content = ob_get_clean();
        $view = $this->getView();
        $this->registerAssets($view);
        return Html::tag($this->container, $content, [ 'class' => $this->containerOptions, 'data-plugin-options' => $this->pluginOptions]);
    }

}
