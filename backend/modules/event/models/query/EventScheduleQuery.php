<?php

namespace backend\modules\event\models\query;

/**
 * This is the ActiveQuery class for [[\backend\modules\event\models\EventSchedule]].
 *
 * @see \backend\modules\event\models\EventSchedule
 */
class EventScheduleQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return \backend\modules\event\models\EventSchedule[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return \backend\modules\event\models\EventSchedule|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
