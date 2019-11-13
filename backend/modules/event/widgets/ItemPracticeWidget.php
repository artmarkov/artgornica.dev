<?php
namespace backend\modules\event\widgets;

use yii\base\Widget;

/**
 * Description of ItemPracticeWidget
 *
 * @author artmarkov
 */
class ItemPracticeWidget extends Widget {
    
    public $model;

    public function run() {
  
        return $this->render('itemPractice', [
                    'model' => $this->model
                    
        ]);
    }

}
