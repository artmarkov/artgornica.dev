<?php

namespace backend\modules\event\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use common\components\behaviors\PurifyBehavior;
use artsoft\db\ActiveRecord;

/**
 * This is the model class for table "{{%event_practice}}".
 *
 * @property int $id
 * @property int $methods_id
 * @property int $time_volume
 * @property string $name
 * @property string $description
 * @property int $created_at
 *
 * @property EventItemPractice[] $eventItemPractices
 * @property EventMethods $methods
 */
class EventPractice extends \artsoft\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%event_practice}}';
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            [
            'class' => TimestampBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at'],
                ],
            ],
            'purify' => [
                'class' => PurifyBehavior::className(),
                'attributes' => ['name','description'],
                
            ],
        ];
    }
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['methods_id', 'name', 'description','time_volume'], 'required'],
            [['methods_id'], 'integer'],
            [['created_at'], 'safe'],
            [['description'], 'string'],
            [['name'], 'string', 'max' => 127],
            [['methods_id'], 'exist', 'skipOnError' => true, 'targetClass' => EventMethods::className(), 'targetAttribute' => ['methods_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('art', 'ID'),
            'methods_id' => Yii::t('art/event', 'Methods ID'),
            'name' => Yii::t('art', 'Name'),
            'description' => Yii::t('art', 'Description'),
            'time_volume' => Yii::t('art/event', 'Time Volume'),
            'created_at' => Yii::t('art', 'Created At'),            
        ];
    }

    public function getCreatedDate()
    {
        return Yii::$app->formatter->asDate(($this->isNewRecord) ? time() : $this->created_at);
    }

    public function getCreatedTime()
    {
        return Yii::$app->formatter->asTime(($this->isNewRecord) ? time() : $this->created_at);
    }

    public function getCreatedDatetime()
    {
        return "{$this->createdDate} {$this->createdTime}";
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEventItemPractices()
    {
        return $this->hasMany(EventItemPractice::className(), ['practice_id' => 'id']);
    }
    /**
     * 
     * @return type array
     */
    public static function getEventPracticeList()
    {
        return \yii\helpers\ArrayHelper::map(static::find()
                ->innerJoin('event_methods', 'event_methods.id = event_practice.methods_id')
                ->select('event_practice.id as id, event_practice.name as name, event_methods.name as name_category')
                ->asArray()->all(), 'id', 'name', 'name_category');
    }
    /**
     * @return \yii\db\ActiveQuery
     * Полный список практик по item_id
     */
    public static function getEventPracticeByItemId($item_id) {
        $data = self::find()
                        ->innerJoin('event_item_practice', 'event_item_practice.practice_id = event_practice.id')                       
                        ->where(['event_item_practice.item_id' => $item_id])
                        ->select(['event_practice.name', 'event_practice.id'])
                        ->asArray()->all();

        return $data;
    }

    /**
     * @return \yii\db\ActiveQuery
     * Полный список практик по name
     */
    public static function getEventPracticeByName($item_id) {
        $data = self::find()
                        ->innerJoin('event_item_practice', 'event_item_practice.practice_id = event_practice.id')                       
                        ->where(['event_item_practice.item_id' => $item_id])
                        ->select(['event_practice.name as name', 'event_practice.id as id'])
                        ->indexBy('id')->column();

        return $data;
    }
    /**
     * метод считает сумму минут включенных практик выбранного занятия $id
     * @param type $id model EventItem
     * @return type integer
     */
    public static function getEventPracticeTime($id) {
        $result = 0;
        $practices = static::find()
                        ->innerJoin('event_item_practice', 'event_item_practice.practice_id = event_practice.id')
                        ->where(['event_item_practice.item_id' => $id])
                        ->select('event_practice.time_volume')
                        ->asArray()->all();
        foreach ($practices as $items) {
            $result += $items['time_volume'];
        }
        // echo '<pre>' . print_r($result, true) . '</pre>';
        return $result;
    }
    /**
     * метод считает сумму минут включенных практик выбранного занятия $item_programm_id в рамках программы 
     * @param type $id model EventItemProgramm
     * @return type integer
     */
    public static function getEventProgrammPracticeTime($item_programm_id) {
        $result = 0;
        $practices = static::find()
                        ->innerJoin('event_item_programm_practice', 'event_item_programm_practice.practice_id = event_practice.id')
                        ->where(['event_item_programm_practice.item_programm_id' => $item_programm_id])
                        ->select('event_practice.time_volume')
                        ->asArray()->all();
        foreach ($practices as $items) {
            $result += $items['time_volume'];
        }
        // echo '<pre>' . print_r($result, true) . '</pre>';
        return $result;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMethods()
    {
        return $this->hasOne(EventMethods::className(), ['id' => 'methods_id']);
    }

    /* Геттер для названия метода */
    public function getMethodsName()
    {
        return $this->methods->name;
    }
    /**
     * {@inheritdoc}
     * @return \backend\modules\event\models\query\EventPracticeQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \backend\modules\event\models\query\EventPracticeQuery(get_called_class());
    }
}
