<?php

namespace backend\modules\event\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "{{%event_place}}".
 *
 * @property int $id
 * @property string $name
 * @property string $address
 * @property string $phone
 * @property string $phone_optional
 * @property string $email
 * @property string $сontact_person
 * @property string $coords
 * @property int $map_zoom
 * @property string $description
 * @property int $created_at
 * @property int $updated_at
 * @property string $event_color
 * @property string $event_text_color
 *
 * @property EventSchedule[] $eventSchedules
 */
class EventPlace extends \artsoft\db\ActiveRecord
{
    public  $map_address;
    
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%event_place}}';
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'address', 'phone', 'email', 'сontact_person', 'coords'], 'required'],
            [['map_zoom'], 'integer'],
            ['email', 'email'],
            [['created_at', 'updated_at'], 'safe'],
            [['name', 'сontact_person'], 'string', 'max' => 127],
            [['address', 'email', 'description'], 'string', 'max' => 255],
            [['phone', 'phone_optional'], 'string', 'max' => 24],
            ['coords', 'string', 'max' => 64],
            [['event_color', 'event_text_color'], 'string', 'max' => 32],
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
            'address' => Yii::t('art', 'Address'),
            'phone' => Yii::t('art', 'Phone'),
            'phone_optional' => Yii::t('art', 'Phone Optional'),
            'email' => Yii::t('art', 'Email'),
            'сontact_person' => Yii::t('art', 'Contact Person'),
            'coords' => Yii::t('art', 'Coords'),
            'map_zoom' => Yii::t('art', 'Map Zoom'),
            'description' => Yii::t('art', 'Description'),
            'created_at' => Yii::t('art', 'Created At'),
            'updated_at' => Yii::t('art', 'Updated At'),
            'event_color' => Yii::t('art/event', 'Event Color'),
            'event_text_color' => Yii::t('art/event', 'Event Text Color'),
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
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEventSchedules()
    {
        return $this->hasMany(EventSchedule::className(), ['place_id' => 'id']);
    }

    /**
     * 
     * @return type array
     */
    public static function getPlacesList()
    {
        return \yii\helpers\ArrayHelper::map(static::find()->all(), 'id', 'name');
    }
    /**
     * event/views/schedule/fullcalendar
     * 
     * @return type array
     */
     public static function getEventPlacesList()
    {
      return self::find()->select(['name', 'event_color', 'event_text_color'])->asArray()->all();
    }
    /**
     * {@inheritdoc}
     * @return \backend\modules\event\models\query\EventPlaceQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \backend\modules\event\models\query\EventPlaceQuery(get_called_class());
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
            
             $countSchedule = EventSchedule::find()->where(['place_id' => $this->id])->count();
            if($countSchedule != 0) {
                $link = true;
                $message .= Yii::t('art/event', 'Event Schedules') . ' ';             
            }
                        
            if($link) {
                Yii::$app->session->setFlash('crudMessage', Yii::t('art', 'Integrity violation. Delete the associated data in the models first:') . ' ' . $message);
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
}
