<?php

namespace backend\modules\event\models;
use yii\behaviors\TimestampBehavior;
use common\components\behaviors\DateToTimeBehavior;
use yii\db\ActiveRecord;


/**
 * This is the model class for table "{{%event_schedule}}".
 *
 * @property int $id 
 * @property int $start_timestamp
 * @property int $end_timestamp
 * @property int $all_day
 * @property int $created_at
 * @property int $updated_at
 *
 * @property EventPlace $place

 */
class EventCalendar extends \artsoft\db\ActiveRecord
{
    public $start_time;
    public $end_time;
    
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%event_schedule}}';
    }

     /**
     * @inheritdoc
     */
    public function behaviors() {
        return [
            [
                'class' => TimestampBehavior::className(),
            ],            
            [
                'class' => DateToTimeBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_VALIDATE => 'start_time',
                    ActiveRecord::EVENT_AFTER_FIND => 'start_time',
                ],
                'timeAttribute' => 'start_timestamp',
            ],
            [
                'class' => DateToTimeBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_VALIDATE => 'end_time',
                    ActiveRecord::EVENT_AFTER_FIND => 'end_time',
                ],
                'timeAttribute' => 'end_timestamp',
            ]
        ];
    }
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['start_timestamp', 'end_timestamp'], 'required'],
            [['all_day'], 'integer'],
            [['start_timestamp', 'end_timestamp'], 'safe'],
            [['all_day'], 'default', 'value' => 0],
            [['created_at', 'updated_at'], 'safe'],
            ['start_time', 'date', 'format' => 'php:d.m.Y H:i'],
            ['end_time', 'date', 'format' => 'php:d.m.Y H:i'],           
          ];
    }   
}    
