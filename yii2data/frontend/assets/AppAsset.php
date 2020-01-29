<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace frontend\assets;

use Yii;
use yii\web\AssetBundle;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [

        'https://fonts.googleapis.com/css?family=Open+Sans:300,400,700,800',
        'css/font-awesome.css',
        'plugins/magnific-popup/magnific-popup.css',        
        
        'css/animate.css',        
        'css/blog.css',
        
        'css/portfolio.css',
        
        'css/essentials.css',
        'css/layout.css',
        'css/layout-responsive.css',
        'css/color_scheme/red.css',
        'css/site.css',
        
        'css/countdown.css',
    ];

    public $js = [

        'plugins/jquery.easing.1.3.js',
        'plugins/jquery.cookie.js',
        'plugins/jquery.appear.js',
        'plugins/jquery.isotope.js',
        'plugins/masonry.js',
        
        'plugins/magnific-popup/jquery.magnific-popup.min.js',
        'plugins/stellar/jquery.stellar.min.js',
        'plugins/knob/js/jquery.knob.js',
        'plugins/jquery.backstretch.min.js',
        
        'js/scripts.js',
        'js/site.js',
        
        'plugins/jquery-countdown/jquery.countdown.min.js',
        'js/countdown.js'
    ];

    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapPluginAsset',
    ];

}