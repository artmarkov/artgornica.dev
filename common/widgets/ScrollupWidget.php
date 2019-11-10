<?php
/**
 * Created by PhpStorm.
 * User: Артур
 * Date: 03.06.2018
 * Time: 15:52
 * Кнопка вверх
 */

namespace common\widgets;

use Yii;
use yii\base\Widget;
use common\assets\WidgetsAsset;

class ScrollupWidget extends Widget{
    public function run() {
        //Подключаем свой файл Asset
        WidgetsAsset::register($this->view);
        return $this->render('scrollup',[
        ]);
    }
}