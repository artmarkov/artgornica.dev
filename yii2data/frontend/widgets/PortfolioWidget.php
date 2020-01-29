<?php

namespace frontend\widgets;

use yii\helpers\Html;

/**
 * Description of PortfolioWidget
 *
 * @author markov-av
 */
class PortfolioWidget extends \yii\base\Widget {

    public $slides;
    // default from docs
    public $container = ['class' => 'row'];
    // none by default
    public $ulOptions = ['class' => 'sort-destination isotope fullcenter fadeIn', 'data-sort-id' => 'isotope-list'];
    //<li>
    public $itemsOptions = ['class' => 'isotope-item'];
    // <div>
    public $wrapperOptions = ['class' => 'item-box'];
    // <a>
    public $linkOptions = ['class' => 'item-hover'];
    // <span>
    public $spanOptions = ['class' => 'overlay color2'];
    //image
    public $imageOptions = ['class' => 'img-responsive', 'width' => '260', 'height' => '260'];
    
    public $defaultContent = '<strong>VIEW</strong> IMAGES';
    
    private $rawSliderHtml;

    public function init() {
        parent::init();
    }

    public function run() {

        $this->buildPortfolio();

        return $this->getSliderHtml();
    }

    public function buildPortfolio() {
        $this->rawSliderHtml = '';
        $this->rawSliderHtml .= Html::beginTag('div', $this->container);
        $this->rawSliderHtml .= Html::beginTag('ul', $this->ulOptions);

        $this->rawSliderHtml .= $this->renderItems();

        $this->rawSliderHtml .= Html::endTag('ul');
        $this->rawSliderHtml .= Html::endTag('div');
    }

    public function renderItems() {
        $slidesHtml = '';
        foreach ($this->slides as $slide) {
            $slidesHtml .= $this->renderSlide($slide);
        }
        return $slidesHtml;
    }

    public function renderSlide($slide) {
        if (!isset($slide['image']) || !isset($slide['image']['src']) || empty($slide['image']['src'])) {
            throw new \yii\base\InvalidConfigException('Portfolio Error: Missing slide image!');
        }

        if (!isset($slide['options'])) {
            $slide['options'] = $this->itemsOptions;
        }

        if (!isset($slide['link'])) {
            $slide['link'] = $this->linkOptions;
        }

        if (!isset($slide['content'])) {
            $slide['content'] = $this->defaultContent;
        }
        if (!isset($slide['image']['options'])) {
            $slide['image']['options'] = $this->imageOptions;
        }

        $slideHtml = '';

        $slideHtml = '';
        $slideHtml .= Html::beginTag('li', $slide['options']);
        $slideHtml .= Html::beginTag('div', $this->wrapperOptions);
        $slideHtml .= Html::beginTag('figure');
        $slideHtml .= Html::beginTag('a', $slide['link']);
        $slideHtml .= Html::beginTag('span', $this->spanOptions);
        $slideHtml .= Html::endTag('span');
        $slideHtml .= Html::beginTag('span', ['class' => 'inner']);
        $slideHtml .= Html::beginTag('span', ['class' => 'block fa fa-plus fsize20']);
        $slideHtml .= Html::endTag('span');
        $slideHtml .= $slide['content'];
        $slideHtml .= Html::endTag('span');
        $slideHtml .= Html::endTag('a');
        // image
        $slideHtml .= Html::img($slide['image']['src'], $slide['image']['options']);

        $slideHtml .= Html::endTag('figure');
        $slideHtml .= Html::endTag('div');
        $slideHtml .= Html::endTag('li');

        return $slideHtml;
    }

    public function getSliderHtml() {
        return $this->rawSliderHtml;
    }

}
?>