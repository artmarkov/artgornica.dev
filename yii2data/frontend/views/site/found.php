<?php

use yii\helpers\Html;
use yii\widgets\LinkPager;
use frontend\models\PostBlogSearch;

$query = yii\helpers\Html::encode($query);

$this->params['breadcrumbs'][] = ['label' => 'Блог', 'url' => ['/blog']];
$this->title = "Результаты поиска по запросу \"$query\"";
$this->params['breadcrumbs'][] = $this->title;

//app\modules\search\SearchAssets::register($this);
//$this->registerJs("jQuery('.search').highlight('{$query}');");
?>

<div class="blog_search">
    <section class="container">
        <div class="row">
            <div class="left col-md-9">

                <?php
                if (!empty($hits)):
                    // echo '<pre>' . print_r($hits, true) . '</pre>';
                    foreach ($hits as $hit):
                        switch ($hit->modelName)
                        {
                            case 'frontend\models\TagBlogSearch':
                                $hit->title = '<i class="fa fa-tags"></i> ' . PostBlogSearch::getFragment($hit->title, $query);
                                break;
                            case 'frontend\models\CategoryBlogSearch':
                                $hit->title = '<i class="fa fa-circle-o"></i> ' . PostBlogSearch::getFragment($hit->title, $query);
                                break;
                            default: break;
                        }
                        ?>                      
                        <h4><a href="<?= yii\helpers\Url::to($hit->url, true) ?>"><?= $hit->title ?></a></h4>
                        <?= PostBlogSearch::getFragment($hit->description, $query) ?>
                        <hr class="half-margins">
                        <?php
                    endforeach;
                else:
                    ?>
                    <div class="alert alert-danger margin-top50"><h4>По запросу "<?= $query ?>" ничего не найдено!</h4></div>
                <?php
                endif;
                ?>
                <!-- PAGINATION -->
                <div class="text-center">
                    <?= LinkPager::widget(['pagination' => $pagination]) ?>
                </div>

            </div>
            <aside class="right col-md-3">
                <?= $this->render('_blog_search', ['text' => "{$query}"]) ?>
            </aside>
        </div>
    </section>
</div>
