<?php
namespace backend\modules\event\widgets;

use yii\base\Widget;

/**
 * Description of ItemProgrammWidget
 *
 * @author artmarkov
 */
class ItemProgrammWidget extends Widget {
    
    public $model;

    public function run() {
  
        return $this->render('itemProgramm', [
                    'model' => $this->model
                    
        ]);
    }

}
