<?php

namespace frontend\widgets;

use yii\helpers\Url;

class MenuCategoryWidget extends \yii\base\Widget {

    public function run() {
        $menuCategory = \artsoft\post\models\Category::getCategoriesMenu();

        echo '<ul class="nav nav-list">';
        //echo '<pre>' . print_r($menuCategory, true) . '</pre>'; 
        foreach ($menuCategory as $slug => $title):
            echo '<li>
                <a href="' . Url::to(['/category/index', 'slug' => $slug]) . '"><i class = "fa fa-circle-o"></i> ' . $title . '</a>
            </li>';
        endforeach;
        echo '</ul>';
    }

}
