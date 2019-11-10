<?php

namespace backend\modules\event\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\event\models\EventPlace;

/**
 * EventPlaceSearch represents the model behind the search form about `backend\modules\event\models\EventPlace`.
 */
class EventPlaceSearch extends EventPlace
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'map_zoom', 'created_at', 'updated_at'], 'integer'],
            [['name', 'address', 'phone', 'phone_optional', 'email', 'сontact_person', 'coords', 'description'], 'safe'],
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
        $query = EventPlace::find();

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
            'map_zoom' => $this->map_zoom,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'address', $this->address])
            ->andFilterWhere(['like', 'phone', $this->phone])
            ->andFilterWhere(['like', 'phone_optional', $this->phone_optional])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'сontact_person', $this->сontact_person])
            ->andFilterWhere(['like', 'coords', $this->coords])
            ->andFilterWhere(['like', 'description', $this->description]);

        return $dataProvider;
    }
}
