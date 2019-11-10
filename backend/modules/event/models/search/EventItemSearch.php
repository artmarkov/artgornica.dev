<?php

namespace backend\modules\event\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\event\models\EventItem;

/**
 * EventItemSearch represents the model behind the search form about `backend\modules\event\models\EventItem`.
 */
class EventItemSearch extends EventItem
{
   
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'created_at', 'updated_at', 'sortOrder'], 'integer'],
            [['name', 'description'], 'safe'],   
            ['gridPracticeSearch', 'string'],
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
        $query = EventItem::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => Yii::$app->request->cookies->getValue('_grid_page_size', 20),
            ],
            'sort' => [
                'defaultOrder' => [
                    'sortOrder' => SORT_ASC,
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
        $query->with(['eventPractices']);       
        
        if ($this->gridPracticeSearch) {
            $query->joinWith(['eventPractices']);
        }
        
        $query->andFilterWhere([
            'id' => $this->id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'event_item_practice.practice_id' => $this->gridPracticeSearch,
        ]);

        $query->andFilterWhere(['like', 'event_item.name', $this->name])
            ->andFilterWhere(['like', 'event_item.description', $this->description]);
        
        return $dataProvider;
    }
}
