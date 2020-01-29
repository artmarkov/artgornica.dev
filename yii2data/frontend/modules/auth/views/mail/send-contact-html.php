<?php
/**
 * @var $this yii\web\View
 * @var $user artsoft\models\User
 */
use yii\helpers\Html;


?>

<div class="send-contact">
    <p><b><?= Yii::t('art', 'Message for') . '</b> ' . Yii::$app->name ?></p> 

    <p><b><?= Yii::t('art', 'Title') . ':</b> ' . Html::encode($subject) ?></p> 

    <p><b><?= Yii::t('art', 'Content') . ':</b> ' . Html::encode($body) ?></p>
</div>

