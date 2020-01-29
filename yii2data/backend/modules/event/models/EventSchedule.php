<?php

namespace backend\modules\event\models;
use yii\behaviors\TimestampBehavior;
use artsoft\behaviors\DateToTimeBehavior;
use yii\db\ActiveRecord;
use backend\components\models\User;

use Yii;

/**
 * This is the model class for table "{{%event_schedule}}".
 *
 * @property int $id
 * @property int $programm_id
 * @property int $item_programm_id
 * @property int $place_id
 * @property int $start_timestamp
 * @property int $end_timestamp
 * @property string $description
 * @property int $all_day
 * @property int $created_at
 * @property int $updated_at
 *
 * @property EventPlace $place
 * @property EventProgramm $programm
 * @property EventItem $item
 */
class EventSchedule extends \artsoft\db\ActiveRecord
{
    const COUNT_EVENT_INDEX = 5;
    
    public $start_time;
    public $end_time;
    
    public $gridUsersSearch;
    public $item_id;
    
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
                'class' => \artsoft\behaviors\ManyHasManyBehavior::className(),
                'relations' => [
                    'scheduleUsers' => 'users_list',
                ],
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
            [['programm_id', 'item_programm_id', 'place_id', 'start_time', 'end_time'], 'required'],
            [['programm_id', 'item_programm_id', 'place_id', 'all_day'], 'integer'],
            [['start_timestamp', 'end_timestamp'], 'safe'],
            [['all_day'], 'default', 'value' => 0],
            [['description'], 'string'],
            [['place_id'], 'exist', 'skipOnError' => true, 'targetClass' => EventPlace::className(), 'targetAttribute' => ['place_id' => 'id']],
            [['programm_id'], 'exist', 'skipOnError' => true, 'targetClass' => EventProgramm::className(), 'targetAttribute' => ['programm_id' => 'id']],
            [['item_programm_id'], 'exist', 'skipOnError' => true, 'targetClass' => EventItemProgramm::className(), 'targetAttribute' => ['item_programm_id' => 'id']],
            ['start_timestamp', 'compareTimestamp'],
            [['created_at', 'updated_at'], 'safe'],
            ['start_time', 'date', 'format' => 'php:d.m.Y H:i'],
            ['end_time', 'date', 'format' => 'php:d.m.Y H:i'],
            [['users_list'], 'safe'],
          ];
    }
    /**
     * сравнение даты начала и окончания/ дата окончания должна быть меньше даты начала
     */
    public function compareTimestamp()
    {
        if (!$this->hasErrors()) {

            if ($this->end_timestamp < $this->start_timestamp) {
                $this->addError('start_time', Yii::t('art/event', 'The event start date must be greater than the end date.'));
            }
        }
    }
    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('art', 'ID'),
            'programm_id' => Yii::t('art/event', 'Programm ID'),
            'item_programm_id' => Yii::t('art/event', 'Item ID'),
            'place_id' => Yii::t('art/event', 'Place ID'),
            'start_timestamp' => Yii::t('art/event', 'Start Time'),
            'end_timestamp' => Yii::t('art/event', 'End Time'),
            'start_time' => Yii::t('art/event', 'Start Time'),
            'end_time' => Yii::t('art/event', 'End Time'),
            'description' => Yii::t('art', 'Description'),
            'all_day' => Yii::t('art/event', 'All Day'),
            'created_at' => Yii::t('art', 'Created At'),
            'updated_at' => Yii::t('art', 'Updated At'),
            'users_list' => Yii::t('art/event', 'Users List'),
            'gridUsersSearch' => Yii::t('art/event', 'Users List'),
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
    
    public function getStartDate()
    {
        return Yii::$app->formatter->asDate($this->start_timestamp);
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPlace()
    {
        return $this->hasOne(EventPlace::className(), ['id' => 'place_id']);
    }

     /* Геттер для названия места */
    public function getPlaceName()
    {
        return $this->place->name;
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProgramm()
    {
        return $this->hasOne(EventProgramm::className(), ['id' => 'programm_id']);
    }

    /* Геттер для названия программы */
    public function getProgrammName()
    {
        return $this->programm->name;
    }
    
    /* Геттер для содержания программы */
    public function getProgrammDescription()
    {
        return $this->programm->description;
    }
    /* Геттер для вида программы (инд или групп) */
    public function getProgrammVid()
    {
        return $this->programm->vid_id;
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getItem()
    {
        return $this->hasOne(EventItem::className(), ['id' => 'item_id'])
                ->viaTable('{{%event_item_programm}}', ['id' => 'item_programm_id']); 
    }

     /**
     * @return \yii\db\ActiveQuery
     */
    public function getItemProgramm()
    {
        return $this->hasOne(EventItemProgramm::className(), ['id' => 'item_programm_id']);
    }
    /* Геттер для названия события */
    public function getItemName()
    {
        return $this->item->name;
    }
    /* Геттер для названия события */
    public function getFullItemName()
    {
        return $this->itemProgramm->fullItemName;
    }
     /* Геттер для ко-ва занятий */
    public function getQtyItems()
    {
        return $this->itemProgramm->qty_items;
    }
    
    /* Геттер для содержания события */
    public function getItemDescription()
    {
        return $this->item->description;
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getScheduleUsers()
    {
        return $this->hasMany(User::className(), ['id' => 'user_id'])
                ->viaTable('{{%event_schedule_users}}', ['schedule_id' => 'id']);                             
    }
    
    /**
     * getScheduleUsersList
     *
     * @return array
     */
    public static function getScheduleUsersList()
    {
        $users = User::find()
                ->andWhere(['in', 'user.status', User::STATUS_ACTIVE]) // заблокированных не добавляем в список
                ->select(['user.id as id', "CONCAT(user.last_name,' ',user.first_name,' [',user.username,']') AS name"])
                ->orderBy('user.last_name')
                ->asArray()->all();
        return \yii\helpers\ArrayHelper::map($users, 'id', 'name');
    }
     
    /**
     * {@inheritdoc}
     * @return \backend\modules\event\models\query\EventScheduleQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \backend\modules\event\models\query\EventScheduleQuery(get_called_class());
    } 
    /**
     *
     * @inheritdoc
     */
    public static function getCarouselOption()
    {
    return [
            'items' => 2,
            'single_item' => false,
            'navigation' => true,
            'pagination' => true,
            'transition_style' => 'fade',
            'auto_play' => '9000',           
            ];
    }

    /**
     * 
     */
    public static function getEventScheduleList()
    {
        $data = self::find()
                ->innerJoin('event_programm', 'event_programm.id = event_schedule.programm_id')
                ->innerJoin('event_vid', 'event_vid.id = event_programm.vid_id')
                ->where(['event_vid.status_vid' => EventVid::STATUS_VID_GROUP]);

        $data_count = clone $data;
        $count = $data_count->where(['>=', 'start_timestamp', time()])->count();
        if ($count >= EventSchedule::COUNT_EVENT_INDEX)
        {
            return $data->where(['>=', 'start_timestamp', time()]) //выводим все новые занятия
                            ->orderBy('start_timestamp DESC')
                            ->all();
        }
        else
        {
            return $data->limit(EventSchedule::COUNT_EVENT_INDEX) 
                            ->orderBy('start_timestamp DESC')
                            ->all();
        }
    }
}    
