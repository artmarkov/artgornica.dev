<?php

use yii\widgets\LinkPager;

/* @var $this yii\web\View */

$this->title = '#' . $tag->title;
$this->params['breadcrumbs'][] = $this->title;
?>
<div id="blog">
    <section class="container masonry-sidebar">
        <div class="row">
            <div class="left col-md-9">
                <ul class="masonry-list">

                    <?php foreach ($posts as $post) : ?>
                        <?= $this->render('/items/post-masonry.php', ['post' => $post, 'page' => 'tag']) ?>

                    <?php endforeach; ?>

                </ul>

                <div class="clearfix"></div>

                <!-- PAGINATION -->
                <div class="text-center">
                    <?= LinkPager::widget(['pagination' => $pagination]) ?>
                </div>

            </div>

            <aside class="right col-md-3">
                 <?= $this->render('/layouts/right_block.php') ?>
            </aside>
            
        </div>
    </section>

</div>
