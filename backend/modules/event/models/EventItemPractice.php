<?php

namespace backend\modules\event\models;

use Yii;

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
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['item_id', 'practice_id'], 'required'],
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
            'id' => Yii::t('art/event', 'ID'),
            'item_id' => Yii::t('art/event', 'Item ID'),
            'practice_id' => Yii::t('art/event', 'Practice ID'),
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
}
