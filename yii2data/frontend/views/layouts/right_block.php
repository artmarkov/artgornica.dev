<?php
use yii\helpers\Url;

?>
<!-- blog search -->

<?= $this->render('@frontend/views/site/_blog_search', ['text' => '']) ?>

<!-- recent work -->
<!--<div class="widget">

    <h4 class="uppercase"></h4>

    <a class="popup-image thumb" href="../frontend/web/images/preview/slider/1.jpg">
        <img src="../frontend/web/images/1x1.png" class="img-responsive" data-src="holder.js/85x85/#888:#555555/auto/" alt="img" />
    </a>
    <a class="popup-video thumb" href="http://www.youtube.com/watch?v=kh29_SERH0Y?rel=0">
        <img src="../frontend/web/images/1x1.png" class="ajax-project img-responsive" data-src="holder.js/85x85/#676767:#555555/auto/" alt="img" />
    </a>
    <a class="popup-video thumb" href="http://vimeo.com/23630702">
        <img src="../frontend/web/images/1x1.png" class="ajax-project img-responsive" data-src="holder.js/85x85/#888:#555555/auto/" alt="img" />
    </a>

    <a class="external ajax-project thumb" href="project-external-1.html">
        <img src="../frontend/web/images/1x1.png" class="ajax-project img-responsive" data-src="holder.js/85x85/#676767:#555555/auto/" alt="img" />
    </a>
    <a class="external ajax-project thumb" href="project-external-2.html">
        <img src="../frontend/web/images/1x1.png" class="ajax-project img-responsive" data-src="holder.js/85x85/#888:#555555/auto/" alt="img" />
    </a>
    <a class="external ajax-project thumb" href="project-external-3.html">
        <img src="../frontend/web/images/1x1.png" class="ajax-project img-responsive" data-src="holder.js/85x85/#676767:#555555/auto/" alt="img" />
    </a>

    <div class="clearfix"></div>
</div>-->
<!-- categories -->
<div class="widget">
<h4 class="uppercase"><?= Yii::t('art/post', 'Blog topics') ?></h4>
    
    <?php
    $categoryKey = '__categoryKey' . Yii::$app->language;

    if (!$menuCategory = Yii::$app->cache->get($categoryKey)) {
        $menuCategory = \frontend\widgets\MenuCategoryWidget::widget();

        Yii::$app->cache->set($categoryKey, $menuCategory, 3600);
    }
    echo $menuCategory;
    ?>
    
</div>

<!-- recent posts -->
<div class="widget">
    
    <h4 class="uppercase"><?= Yii::t('art/post', 'Keywords') ?></h4>
    <?php
    $tagCloudKey = '__cloudKey' . Yii::$app->language;

    if (!$TagCloud = Yii::$app->cache->get($tagCloudKey)) {
        $TagCloud = \frontend\widgets\TagCloudWidget::widget([
                    'maxTags' => 30,
                    'urlRoute' => '/tag/index',
                    'tagClasses' => ['fsize13', 'fsize14', 'fsize15', 'fsize16', 'fsize17', 'fsize18', 'fsize19', 'fsize20', 'fsize26'],
                    'tagsArray' => \artsoft\post\models\Tag::getTagsCloud()
        ]);
        Yii::$app->cache->set($tagCloudKey, $TagCloud, 3600);
    }
    echo $TagCloud;
    ?>

</div>

<!-- most popular -->
<!--<div class="widget">
    
    <h4 class="uppercase"><?= Yii::t('art/post', 'Most popular') ?></h4>-->
    <?php
//    $popularKey = '__popularKey' . Yii::$app->language;
//
//    if (!$popular = Yii::$app->cache->get($popularKey)) {
//
//        Yii::$app->cache->set($popularKey, $popular, 3600);
//    }
//    echo $popular;
    ?>

<!--</div>-->
<!-- Recent Comments -->
<div class="widget">  
    <h4 class="uppercase"><?= Yii::t('art/post', 'Recent Comments') ?></h4>
    <div class="white-row">
        <?= artsoft\comment\widgets\RecentComments::widget() ?>    
    </div>
</div>
