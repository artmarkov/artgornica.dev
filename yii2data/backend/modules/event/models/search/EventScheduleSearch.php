<?php

namespace backend\modules\event\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\event\models\EventSchedule;

/**
 * EventScheduleSearch represents the model behind the search form about `backend\modules\event\models\EventSchedule`.
 */
class EventScheduleSearch extends EventSchedule
{
    
     public $placeName;
     public $programmName;
     public $itemName;


     /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'programm_id', 'place_id', 'item_id'], 'integer'],
            [['description', 'all_day'], 'safe'],
            [['placeName','programmName','itemName'], 'string'],
            [['gridUsersSearch'], 'string'],
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
        $query = EventSchedule::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => Yii::$app->request->cookies->getValue('_grid_page_size', 20),
            ],
            'sort' => [
                'defaultOrder' => [
                    'id' => SORT_DESC,
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
        $query->with(['scheduleUsers']);
        $query->with(['item']);
               
        if ($this->gridUsersSearch) {
            $query->joinWith(['scheduleUsers']);
        }
        if ($this->item_id) {
            $query->joinWith(['item']);
        }
         
        $query->andFilterWhere([
            'id' => $this->id,
            'place_id' => $this->place_id,
            'event_item_programm.item_id' => $this->item_id,
            'event_item_programm.programm_id' => $this->programm_id,
            'event_schedule_users.user_id' => $this->gridUsersSearch,
        ]);

        $query->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'all_day', $this->all_day]);

        return $dataProvider;
    }
}
