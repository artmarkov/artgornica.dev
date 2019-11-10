<?php
/* @var $this yii\web\View */

use artsoft\comments\widgets\Comments;
use artsoft\post\models\Post;

/* @var $post artsoft\post\models\Post */

$this->title = $post->title;
$this->params['breadcrumbs'][] = $post->title;
?>
<div id="blog">
    <section class="container masonry-sidebar">
        <div class="row">
            <div class="left col-md-9">            

                <?= $this->render('/items/post.php', ['post' => $post]) ?>

                <div class="divider"><!-- divider -->
                    <i class="fa fa-star"></i>
                </div>
                <div class="clearfix"></div>
                <!-- COMMENTS -->
                <div id="comments">

                    <?php if ($post->comment_status == Post::COMMENT_STATUS_OPEN): ?>
                        <?php echo Comments::widget(['model' => Post::className(), 'model_id' => $post->id]); ?>
                    <?php endif; ?>

                </div>
                <!-- /COMMENTS -->
            </div>
            <aside class="right col-md-3">
                <?= $this->render('/layouts/right_block.php') ?>
            </aside>
        </div>
    </section>
</div>