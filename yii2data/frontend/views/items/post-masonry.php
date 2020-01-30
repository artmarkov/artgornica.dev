<?php

use yii\helpers\Url;
use yii\helpers\Html;
use artsoft\comments\models\Comment;

/* @var $post artsoft\post\models\Post */

$page = (isset($page)) ? $page : 'post';
?>
<li class="masonry-item">
    <div class="item-box appear-animation pull-left inner" data-animation="fadeInDown">
        <!-- article title -->
        <div class="item">
            <!-- article title -->
            <header class="blog-post-masonry">

                <h2><?= Html::a($post->title, ["/site/{$post->slug}"], ['class' => '']); ?></h2>
                <p class="fsize13 nopadding-bottom">

                    <?php if ($post->category): ?>

                        <a href="<?= Url::to(['/category/index', 'slug' => $post->category->slug]) ?>" class="label label-default light">
                            <i class="fa fa-folder-open" aria-hidden="true"></i> <?= $post->category->title ?></a>

                    <?php endif; ?>

                    <span class="scrollTo label label-success light"><i class="fa fa-comment-o"></i> 
                        <?php echo Comment::activeCount($post->className(), $post->id); ?></span>
                    <span class="label label-info light"><i class="fa fa-pencil" aria-hidden="true"></i> <?= $post->publishedDate ?></span>
                </p>
            </header>

            <!-- image -->
            <figure>

                <?php
                $item = \artsoft\mediamanager\models\MediaManager::getMediaFirst($post->className(), $post->id);

                if (!empty($item))
                {

                    echo Html::a('<span class="overlay color"></span><span class="inner">
                    <span class="block fa fa-plus fsize20"></span>
                    <span class="uppercase"><strong>читать</strong> дальше</span>', ["/site/{$post->slug}"], ['class' => 'item-hover']);
                    echo Html::img(\artsoft\media\models\Media::findById($item['media_id'])->getThumbs()['medium'], ['class' => 'img-responsive', 'alt' => '']);
                }
                ?> 

            </figure>
            <!-- TAGS -->
            <?php $tags = $post->tags; ?>
                <?php if (!empty($tags)): ?>
                <p class="fsize13 nopadding-bottom"> 
                    <?php foreach ($tags as $tag): ?>

                        <?= Html::a('<i class="fa fa-tags" aria-hidden="true"></i> ' . $tag->title, ['/tag/index', 'slug' => $tag->slug], ['class' => 'label label-primary light']) ?>

                <?php endforeach; ?>
                </p>
            <?php endif; ?>

            <?= $post->shortContent ?>
            <div>
                <!-- read more button -->
                <?php if ($page != 'post'): ?>
                    <?= Html::a('<i class="fa fa-sign-out"></i><span class="uppercase"> Читать дальше...</span>', ["/site/{$post->slug}"], ['class' => 'btn btn-xs']) ?>
            <?php endif; ?>
            </div>

        </div>
        </div>
            </li>