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
    public $dataProvider;


    public function run() {
        $this->dataProvider = new \yii\data\ActiveDataProvider([
            'query' => \backend\modules\event\models\EventItemPractice::find()
                ->andWhere(['in', 'item_id' , $this->model->id])
                ->orderBy('sortOrder'),
            'sort' => false,
        ]);
        $this->dataProvider->pagination = false;
  
        return $this->render('itemPractice', [
                    'model' => $this->model,
                    'dataProvider' => $this->dataProvider,
                    
        ]);
    }

}
