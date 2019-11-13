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
    public $dataProvider;


    public function run() {
        $this->dataProvider = new \yii\data\ActiveDataProvider([
            'query' => \backend\modules\event\models\EventItemProgramm::find()
                ->andWhere(['in', 'programm_id' , $this->model->id])
                ->orderBy('sortOrder'),
            'sort' => false,
        ]);
        $this->dataProvider->pagination = false;
  
        return $this->render('itemProgramm', [
                    'model' => $this->model,
                    'dataProvider' => $this->dataProvider,
                    
        ]);
    }

}
