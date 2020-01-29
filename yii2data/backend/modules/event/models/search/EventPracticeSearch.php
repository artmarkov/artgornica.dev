<?php

namespace backend\modules\event\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\event\models\EventPractice;

/**
 * EventPracticeSearch represents the model behind the search form about `backend\modules\event\models\EventPractice`.
 */
class EventPracticeSearch extends EventPractice
{
    public $methodsName;
    
    
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'methods_id', 'created_at', 'time_volume'], 'integer'],
            [['name', 'description'], 'safe'],
            ['methodsName', 'string'],           
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
        $query = EventPractice::find();

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
        //    жадная загрузка
        $query->joinWith(['methods']);

        $query->andFilterWhere([
            'id' => $this->id,
            'methods_id' => $this->methods_id,
            'time_volume' => $this->time_volume,
            'created_at' => $this->created_at,
        ]);

        $query->andFilterWhere(['like', 'event_practice.name', $this->name])
            ->andFilterWhere(['like', 'event_practice.description', $this->description]);

        return $dataProvider;
    }
}
