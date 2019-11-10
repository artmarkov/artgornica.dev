<?php

namespace backend\modules\event\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use common\components\behaviors\PurifyBehavior;
use artsoft\db\ActiveRecord;

/**
 * This is the model class for table "{{%event_vid}}".
 *
 * @property int $id
 * @property string $name
 * @property string $description
 * @property int $created_at
 * @property int $status_vid
 *
 * @property EventProgramm[] $eventProgramms
 */
class EventVid extends \artsoft\db\ActiveRecord
{
    const STATUS_VID_INDIV = 0;
    const STATUS_VID_GROUP = 1;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%event_vid}}';
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
            ['status_vid', 'integer'],
            [['name', 'status_vid'], 'required'],
            [['description'], 'string'],
            [['created_at'], 'safe'],
            [['name'], 'string', 'max' => 127],
        ];
    }

    /**
     * getStatusList
     * @return array
     */
    public static function getStatusVidList()
    {
        return array(
            self::STATUS_VID_INDIV => Yii::t('art/event', 'Individual'),
            self::STATUS_VID_GROUP => Yii::t('art/event', 'Group'),           
        );
    }
    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('art', 'ID'),
            'status_vid' => Yii::t('art', 'Status'),
            'name' => Yii::t('art', 'Name'),
            'description' => Yii::t('art', 'Description'),
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
    public function getEventProgramms()
    {
        return $this->hasMany(EventProgramm::className(), ['vid_id' => 'id']);
    }
    /**
     * 
     * @return type array
     */
    public static function getVidList()
    {
        return \yii\helpers\ArrayHelper::map(static::find()->all(), 'id', 'name');
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
            
            $countProgramm = EventProgramm::find()->where(['vid_id' => $this->id])->count();
                if($countProgramm != 0) {
                $link = true;
                $message .= Yii::t('art/event', 'Event Programms') . ' ';            
            }
            $countItem = EventItem::find()->where(['vid_id' => $this->id])->count();
            if($countItem != 0) {
                $link = true;
                $message .= Yii::t('art/event', 'Events') . ' ';             
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
