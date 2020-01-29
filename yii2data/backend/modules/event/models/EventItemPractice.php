<?php

namespace backend\modules\event\models;

use Yii;
use himiklab\sortablegrid\SortableGridBehavior;

/**
 * This is the model class for table "{{%event_item_practice}}".
 *
 * @property int $id
 * @property int $item_id
 * @property int $practice_id
 *
 * @property EventItem $item
 * @property EventPractice $practice
 */
class EventItemPractice extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%event_item_practice}}';
    }

     /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'sort' => [
                'class' => SortableGridBehavior::className(),
                'sortableAttribute' => 'sortOrder',
                'scope' => function ($query) {
                    $query->andWhere(['item_id' => $this->item_id]);
                },
            ],
        ];
    }
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['item_id', 'practice_id'], 'required'],
            [['item_id', 'practice_id'], 'unique', 'targetAttribute' => ['item_id', 'practice_id']],
            [['item_id', 'practice_id'], 'integer'],
            [['item_id'], 'exist', 'skipOnError' => true, 'targetClass' => EventItem::className(), 'targetAttribute' => ['item_id' => 'id']],
            [['practice_id'], 'exist', 'skipOnError' => true, 'targetClass' => EventPractice::className(), 'targetAttribute' => ['practice_id' => 'id']],
        ];
    }

     /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [          
           'practiceName' => Yii::t('art/event', 'Name'),
           'practiceTimeVolume' => Yii::t('art/event', 'Time Volume'),
         
        ];
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getItem()
    {
        return $this->hasOne(EventItem::className(), ['id' => 'item_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPractice()
    {
        return $this->hasOne(EventPractice::className(), ['id' => 'practice_id']);
    }
      /* Геттер для названия практики */
    public function getPracticeName()
    {
        return $this->practice->name;
    }  
      /* Геттер для названия практики */
    public function getPracticeTimeVolume()
    {
        return $this->practice->time_volume;
    }  
     /**
     * метод считает длительность занятия - сумма длятельности практик
     * @param type $item_id
     * @return type integer
     */
    public static function getItemTime($item_id) {
        $result = 0;
        $data = static::find()->joinWith('practice')
                        ->where(['item_id' => $item_id])
                        ->select('time_volume')
                        ->asArray()->all();
        foreach ($data as $items) {
            $result += $items['time_volume'];
        }
        // echo '<pre>' . print_r($data, true) . '</pre>';
        return $result;    
    }
}
