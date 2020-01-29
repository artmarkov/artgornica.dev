<?php

namespace backend\modules\event\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\event\models\EventProgramm;

/**
 * EventProgrammSearch represents the model behind the search form about `backend\modules\event\models\EventProgramm`.
 */
class EventProgrammSearch extends EventProgramm
{
     public $vidName;
     
     /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'created_at', 'updated_at', 'vid_id'], 'integer'],
            [['name', 'description'], 'safe'],            
            [['vidName'], 'string'],
            ['gridItemsSearch', 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = EventProgramm::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => Yii::$app->request->cookies->getValue('_grid_page_size', 20),
            ],
            'sort' => [
                'defaultOrder' => [
                    'id' => SORT_ASC,
                ],
            ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

       //жадная загрузка       
        $query->with(['vid']);
        $query->with(['eventItems']);
       
        
        if ($this->gridItemsSearch) {
            $query->joinWith(['eventItems'])->distinct();
        }
        
        $query->andFilterWhere([
            'id' => $this->id,
            'event_programm.vid_id' => $this->vid_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
//            'programm_price' => $this->programm_price,
            'event_item_programm.item_id' => $this->gridItemsSearch,
        ]);

        $query->andFilterWhere(['like', 'event_programm.name', $this->name])
            ->andFilterWhere(['like', 'event_programm.description', $this->description]);

        return $dataProvider;
    }
}
