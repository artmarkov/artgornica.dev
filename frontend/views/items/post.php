<?php

use yii\helpers\Url;
use yii\helpers\Html;
use artsoft\comments\models\Comment;
use yii\helpers\ArrayHelper;

/* @var $post artsoft\post\models\Post */

$page = (isset($page)) ? $page : 'post';
$post->updateRevision();
//echo '<pre>' . print_r($post->getCarouselOption(), true) . '</pre>';
?>

<!-- article title -->
<header class="blog-post">
    <h1><?= $post->title ?></h1>
    <small class="fsize13">
        <?php if ($post->category): ?>

            <a href="<?= Url::to(['/category/index', 'slug' => $post->category->slug]) ?>" class="label label-default light">
                <i class="fa fa-folder-open" aria-hidden="true"></i> <?= $post->category->title ?></a>

        <?php endif; ?>

        <span class="scrollTo label label-success light"><i class="fa fa-comment-o"></i> 
            <?php echo Comment::activeCount($post->className(), $post->id); ?> коммент.</span>
        <span class="label label-info light"><i class="fa fa-user" aria-hidden="true"></i> <?= $post->author->username ?>: <?= $post->publishedDate ?></span>
    </small>
</header>

    <!-- carousel -->
    
    <?php
    $carousel = ArrayHelper::merge($post->getCarouselOption(), [
                'model_name' => $post->className(),
                'id' => $post->id,
    ]);
    echo \frontend\widgets\CarouselWidget::widget(
            [
                'content_items' => \artsoft\mediamanager\models\MediaManager::getMediaList($carousel['model_name'], $carousel['id']),
                'owl_options' => $carousel,
                'options' =>
                [
                    'type' => 'images',
                    'size' => 'large',
                    'class' => 'owl-carousel text-center controlls-over',
                ],
    ]);
    ?>
    <!-- carousel -->

    <!-- TAGS -->
<?php $tags = $post->tags; ?>
<?php if (!empty($tags)): ?>
    <p class="fsize13 nopadding-bottom nopadding-top"> 
        <?php foreach ($tags as $tag): ?>

            <?= Html::a('<i class="fa fa-tags" aria-hidden="true"></i> ' . $tag->title, ['/tag/index', 'slug' => $tag->slug], ['class' => 'label label-primary light']) ?>

        <?php endforeach; ?>
    </p>
<?php endif; ?>
<!-- article content -->
<article>

    <?=  $post->allContent ?>

</article>



