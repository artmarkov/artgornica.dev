<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),  
    require(__DIR__ . '/params.php')
);

return [
    'id' => 'frontend',
    'homeUrl' => '/',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'frontend\controllers',
    'modules' => [
        'auth' => [
            'class' => 'frontend\modules\auth\AuthModule',
        ],
        'sliderrevolution' => [
        'class' => 'frontend\modules\sliderrevolution\SliderModule',
        'pluginLocation' => '@public/plugins/revolution-slider',
        ],
    ],
    'components' => [
        'view' => [
            'as seo' => [
                'class' => 'artsoft\seo\components\SeoViewBehavior',
            ]
        ],
        'seo' => [
            'class' => 'artsoft\seo\components\Seo',
        ],
        'request' => [
            'cookieValidationKey' => env('FRONTEND_COOKIE_VALIDATION_KEY'),
            'baseUrl' => '',
        ],
        'urlManager' => [
            'class' => 'artsoft\web\MultilingualUrlManager',
            'showScriptName' => false,
            'enablePrettyUrl' => true,
            'rules' => array(
                '<module:auth>/<action:(logout|captcha)>' => '<module>/default/<action>',
                '<module:auth>/<action:(oauth)>/<authclient:\w+>' => '<module>/default/<action>',
            ),
            'multilingualRules' => [
                '<module:auth>/<action:\w+>' => '<module>/default/<action>',
                '<controller:(category|tag)>/<slug:[\w \-]+>' => '<controller>/index',
                '<controller:(category|tag|event)>' => '<controller>/index',
                '<slug:[\w \-]+>' => 'site/blog/',
                '/' => 'site/index',
                '<action:[\w \-]+>' => 'site/<action>',
                '<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
                '<controller:\w+>/<action:\w+>' => '<controller>/<action>',
            ],
            'nonMultilingualUrls' => [
                'auth/default/oauth',
            ],
        ],
        'authClientCollection' => [
            'class' => 'yii\authclient\Collection',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
         'assetManager' => [
            'bundles' => [
                'yii\bootstrap\BootstrapAsset' => [
                    'css' => ['https://maxcdn.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css'],
                ],
                'yii\bootstrap\BootstrapPluginAsset' => [
                    'js'=> ['https://maxcdn.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js']
                ],
                'yii\web\JqueryAsset' => [
                    'js' => [YII_DEBUG ? 'https://code.jquery.com/jquery-2.0.3.js' : 'https://code.jquery.com/jquery-2.0.3.min.js'],
                    'jsOptions' => ['type' => 'text/javascript'],
                ],
            ],
        ],
        'searcher' => [
            'class' => \vintage\search\SearchComponent::class,
            'models' => [
                'post' => [
                    'class' => \frontend\models\PostBlogSearch::class,
                    'label' => 'Posts',
                ],
                'category' => [
                    'class' => \frontend\models\CategoryBlogSearch::class,
                    'label' => 'Category',
                ],
                'tag' => [
                    'class' => \frontend\models\TagBlogSearch::class,
                    'label' => 'Tag',
                ],
            ],
        ],
    ],
    'params' => $params,
];
