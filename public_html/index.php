<?php
defined('YII_DEBUG') or define('YII_DEBUG', true);
defined('YII_ENV') or define('YII_ENV', 'dev');
// Composer
require(__DIR__ . '/../yii2data/vendor/autoload.php');
// Environment
require(__DIR__ . '/../yii2data/common/env.php');
// Yii
require(__DIR__ . '/../yii2data/vendor/yiisoft/yii2/Yii.php');
// Bootstrap application
require(__DIR__ . '/../yii2data/common/config/bootstrap.php');
require(__DIR__ . '/../yii2data/frontend/config/bootstrap.php');

$config = yii\helpers\ArrayHelper::merge(
    require(__DIR__ . '/../yii2data/common/config/main.php'),
    require(__DIR__ . '/../yii2data/frontend/config/main.php')
);

$application = new yii\web\Application($config);
$application->run();