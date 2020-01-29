<?php

namespace backend\modules\event\models;

use Yii;
use himiklab\sortablegrid\SortableGridBehavior;

/**
 * This is the model class for table "{{%event_item_programm}}".
 *
 * @property int $id
 * @property int $programm_id
 * @property int $item_id
 * @property int $price
 * @property int $sortOrder
 * @property string $name_short
 * @property EventItem $item
 * @property EventProgramm $programm
 * @property EventSchedule[] $eventSchedules
 * @property EventSchedule[] $eventSchedules0
 */
class EventItemProgramm extends \yii\db\ActiveRecord
{
    public $gridPractice;
    
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%event_item_programm}}';
    }
    
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            [
                'class' => \artsoft\behaviors\ManyHasManyBehavior::className(),
                'relations' => [
                    'itemProgrammPractices' => 'practice_list',
                ],
            ],
            'sort' => [
                'class' => SortableGridBehavior::className(),
                'sortableAttribute' => 'sortOrder',
                'scope' => function ($query) {
                    $query->andWhere(['programm_id' => $this->programm_id]);
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
            [['programm_id', 'item_id'], 'required'],
            [['programm_id', 'item_id', 'name_short', 'price', 'sortOrder'], 'integer'],
            ['practice_list', 'safe'],
            ['name_short', 'string', 'max' => 32],
            ['name_short', 'default', 'value' => 1],
            [['item_id'], 'exist', 'skipOnError' => true, 'targetClass' => EventItem::className(), 'targetAttribute' => ['item_id' => 'id']],
            [['programm_id'], 'exist', 'skipOnError' => true, 'targetClass' => EventProgramm::className(), 'targetAttribute' => ['programm_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('art/event', 'ID'),
            'programm_id' => Yii::t('art/event', 'Programm ID'),
            'item_id' => Yii::t('art/event', 'Item ID'),
            'name_short' => Yii::t('art/event', 'Name Short'),
            'price' => Yii::t('art/event', 'Price'),
            'itemName' => Yii::t('art', 'Name'),
            'fullItemName' => Yii::t('art', 'Name'),
            'practice_list' => Yii::t('art/event', 'Practice List'),
            'gridPractice' => Yii::t('art/event', 'Practice List'),            
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getItem()
    {
        return $this->hasOne(EventItem::className(), ['id' => 'item_id']);
    }
    
     /* Геттер для названия события */
    public function getItemName()
    {
        return $this->item->name;
    }  
    /* Геттер для полного названия события */
    public function getFullItemName()
    {
        return $this->item->name . ' ' . $this->name_short;
    }
    
     /* Геттер для времени проведения */
    public function getTimeVolume()
    {
        return EventPractice::getEventProgrammPracticeTime($this->id);
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProgramm()
    {
        return $this->hasOne(EventProgramm::className(), ['id' => 'programm_id']);
    }
    
     /**
     * @return \yii\db\ActiveQuery
     */
    public function getItemProgrammPractices()
    {
        return $this->hasMany(EventPractice::className(), ['id' => 'practice_id'])
                ->viaTable('{{%event_item_programm_practice}}', ['item_programm_id' => 'id']);
    } 
    
    /**
     * метод считает полную стоимость программы
     * @param type $programm_id
     * @return type integer
     */
    public static function getFullItemPrice($programm_id) {
        $result = 0;
        $data = static::find()
                        ->where(['programm_id' => $programm_id])
                        ->select('price')
                        ->asArray()->all();
        foreach ($data as $items) {
            $result += $items['price'];
        }
        // echo '<pre>' . print_r($result, true) . '</pre>';
        return $result;    
    }
    /**
     * 
     * @param type $programm_id
     * @return type integer
     */
     public static function getCountItem($programm_id) {
       
        return static::find()->where(['event_item_programm.programm_id' => $programm_id])->count();    
    }
    /**
     * @return \yii\db\ActiveQuery
     * Полный список занятий по name
     */
    public static function getItemByName($programm_id) {
        $data = self::find()
                        ->innerJoin('event_item', 'event_item.id = event_item_programm.item_id')
                        ->where(['event_item_programm.programm_id' => $programm_id])
                        ->select(["CONCAT(event_item.name,' ',event_item_programm.name_short) AS name", 'event_item_programm.id as id'])
                        ->orderBy('event_item_programm.sortOrder')                
                        ->indexBy('id')->column();

        return $data;
    }
    /**
     * @return \yii\db\ActiveQuery
     * Полный список занятий по programm_id
     */
    public static function getItemByProgrammId($programm_id) {
        $data = self::find()
                        ->innerJoin('event_item', 'event_item.id = event_item_programm.item_id')
                        ->where(['event_item_programm.programm_id' => $programm_id])
                        ->select(["CONCAT(event_item.name,' ',event_item_programm.name_short) AS name", 'event_item_programm.id as id'])
                        ->orderBy('event_item_programm.sortOrder')
                        ->asArray()->all();

        return $data;
    }
}
