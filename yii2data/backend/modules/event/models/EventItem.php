<?php

namespace backend\modules\event\models;
use yii\behaviors\TimestampBehavior;
use himiklab\sortablegrid\SortableGridBehavior;

use Yii;

/**
 * This is the model class for table "{{%event_item}}".
 *
 * @property int $id
 * @property int $sortOrder
 * @property string $name
 * @property string $description
 * @property string $assignment
 * @property int $created_at
 * @property int $updated_at
 * 
 * @property EventItemPractice[] $eventItemPractices
 * @property EventItemProgramm[] $eventItemProgramms
 * @property EventSchedule[] $eventSchedules
 */
class EventItem extends \artsoft\db\ActiveRecord
{
     public $gridPracticeSearch;
     public $mediaFirst;
     public $practice_list;


     /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%event_item}}';
    }
    
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
            ],            
            'sort' => [
                'class' => SortableGridBehavior::className(),
                'sortableAttribute' => 'sortOrder',
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'description'], 'required'],
            [['sortOrder'], 'integer'],
            [['description', 'assignment'], 'string'],           
            [['created_at', 'updated_at'], 'safe'],
            [['practice_list'], 'safe'],
            [['name'], 'string', 'max' => 127],
            
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('art', 'ID'),
            'name' => Yii::t('art', 'Name'),
            'description' => Yii::t('art', 'Description'),
            'assignment' => Yii::t('art/event', 'Assignment'),
            'created_at' => Yii::t('art', 'Created At'),
            'updated_at' => Yii::t('art', 'Updated At'),
            'practice_list' => Yii::t('art/event', 'Practice List'),
            'gridPracticeSearch' => Yii::t('art/event', 'Practice List'),
            'timeVolume' => Yii::t('art/event', 'Time Volume'),           
            'mediaFirst' => Yii::t('art/media', 'Media First'),           
        ];
    }
    
    public function getCreatedDate()
    {
        return Yii::$app->formatter->asDate(($this->isNewRecord) ? time() : $this->created_at);
    }

    public function getUpdatedDate()
    {
        return Yii::$app->formatter->asDate(($this->isNewRecord) ? time() : $this->updated_at);
    }

    public function getCreatedTime()
    {
        return Yii::$app->formatter->asTime(($this->isNewRecord) ? time() : $this->created_at);
    }

    public function getUpdatedTime()
    {
        return Yii::$app->formatter->asTime(($this->isNewRecord) ? time() : $this->updated_at);
    }

    public function getCreatedDatetime()
    {
        return "{$this->createdDate} {$this->createdTime}";
    }

    public function getUpdatedDatetime()
    {
        return "{$this->updatedDate} {$this->updatedTime}";
    }

    /* Геттер для времени проведения */
    public function getTimeVolume()
    {
        return EventPractice::getEventPracticeTime($this->id);
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEventPractices()
    {
        return $this->hasMany(EventPractice::className(), ['id' => 'practice_id'])
                    ->viaTable('{{%event_item_practice}}', ['item_id' => 'id']);        
    }
     /**
     * 
     * @return type array
     */
    public static function getEventItemList()
    {
        return \yii\helpers\ArrayHelper::map(static::find()
                ->select('event_item.id as id, event_item.name as name')
                ->asArray()->all(), 'id', 'name');
    }
   
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEventItemProgramms()
    {
        return $this->hasMany(EventItemProgramm::className(), ['item_id' => 'id']);
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEventSchedules()
    {
        return $this->hasMany(EventSchedule::className(), ['event_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return \backend\modules\event\models\query\EventItemQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \backend\modules\event\models\query\EventItemQuery(get_called_class());
    }
    
    /**
     * @return \yii\db\ActiveQuery
     * Полный список занятий по name
     */
    public static function getEventItemByName() {
        $data = self::find()->select(['event_item.name', 'event_item.id'])
                        ->indexBy('id')->column();

        return $data;
    }

    /**
     * 
     * @return boolean
     */
     public function beforeDelete()
     {             
         
        if (parent::beforeDelete()) {
            
            $link = false;
            $message = NULL;
            
            $countProgramm = EventItemProgramm::find()->where(['item_id' => $this->id])->count();
                if($countProgramm != 0) {
                $link = true;
                $message .= Yii::t('art/event', 'Event Programms') . ' ';            
            }
            $countSchedule = EventSchedule::find()->where(['item_id' => $this->id])->count();
            if($countSchedule != 0) {
                $link = true;
                $message .= Yii::t('art/event', 'Event Schedules') . ' ';             
            }
            
            if($link) {
                Yii::$app->session->setFlash('info', Yii::t('art', 'Integrity violation. Delete the associated data in the models first:') . ' ' . $message);
                return false;            
            }
            else {                
                return true;
            }       
        }           
         else {
            return false;
        }
    }
    /**
     *
     * @inheritdoc
     */
    public static function getCarouselOption()
    {
    return [
            'items' => 1,
            'single_item' => true,
            'navigation' => true,
            'pagination' => true,
            'transition_style' => 'fade',
            'auto_play' => '9000',           
            ];
    }
     /**
     * @return \yii\db\ActiveQuery
     */
    public static function getMediaInfo($id)
    {
       //$model_name = $class::getTableSchema()->fullName;
        return self::find()                 
                ->where(['id' => $id])
                ->select(['name AS name', "CONCAT('event/update/',id) AS url"])
                ->asArray()
                ->one();    
    }
     /**
     * 
     * @return type array
     */
     public  function getEventPracticesList()
    {
        // $data = array();
         
         $items = $this->eventPractices;      
        echo '<pre>' . print_r($items, true) . '</pre>';
        
//        foreach ($items as $key => $item) :
//          $content = '';
//          $content .= Html::beginTag('div', ['id' => 'media-base']);
//          $content .= Html::img(Media::findById($item['media_id'])->getDefaultThumbUrl());
//          $content .= Html::endTag('div');
//          $content .= Html::beginTag('div', ['id' => 'media-remove']);
//          $content .= Html::tag('a','<i class="glyphicon glyphicon-trash" aria-hidden="true"></i>', 
//                                    [
//                                        'class' => 'btn btn-sm btn-default remove-media-item', 
//                                        'data-id' => $item['id'], 
//                                        'href' => '#', 
//                                        'alt' => '', 
//                                        'title' => Yii::t('art', 'Delete')
//                                    ]);
//          $content .= Html::endTag('div');
//          $data[$key] = ['content' => $content];
//            
//        endforeach;
        
       // return $data;
    } 
    
}
