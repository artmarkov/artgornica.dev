<?php

namespace frontend\widgets;

use yii\base\Widget;

/**
 * Description of ItemProgrammWidget
 *
 * @author artmarkov
 */
class ScheduleUserWidget extends Widget {

    public $model;
    public $pagination;

    public function run() {

        return $this->render('scheduleUser', [
                    'model' => $this->model,
                    'pagination' => $this->pagination
        ]);
    }

}
