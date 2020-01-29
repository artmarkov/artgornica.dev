<?php

namespace backend\modules\event\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\event\models\EventPlan;

/**
 * EventPlanSearch represents the model behind the search form about `backend\modules\event\models\EventPlan`.
 */
class EventPlanSearch extends EventPlan
{
     public $placeName;
     public $programmName;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'programm_id', 'place_id', 'start_timestamp', 'end_timestamp', 'created_at', 'updated_at'], 'integer'],
            [['color', 'description'], 'safe'],
            [['placeName','programmName'], 'string'],
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
        $query = EventPlan::find();

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

        $query->andFilterWhere([
            'id' => $this->id,
            'programm_id' => $this->programm_id,
            'place_id' => $this->place_id,
            'start_timestamp' => $this->start_timestamp,
            'end_timestamp' => $this->end_timestamp,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'color', $this->color])
            ->andFilterWhere(['like', 'description', $this->description]);

        return $dataProvider;
    }
}
