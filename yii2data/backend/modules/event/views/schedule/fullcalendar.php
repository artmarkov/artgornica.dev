<?php


use artsoft\helpers\Html;
//use common\models\calendar\EventCategory;
use yii\web\JsExpression;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

//echo '<pre>' . print_r($events, true) . '</pre>';
$this->title = Yii::t('art/event','Schedule Calendar');
$this->params['breadcrumbs'][] = ['label' => Yii::t('art/event','Events'), 'url' => ['default/index']];
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="event-index">

    <div class="row">
        <div class="col-sm-12">
            <h3 class="lte-hide-title page-title"><?=  Html::encode($this->title) ?></h3>

        </div>
    </div>

    <div class="panel panel-default">
        <div class="panel-body">

            <?php


// выбираем мышкой область или кликаем в пустое поле
$JSSelect = <<<EOF
    function(start, end, jsEvent, view, resource ) {
        var eventData;
            eventData = {
                id: 0,
                start: start.format(),
                end: end.format(),
                resourceId: resource ? resource.id : null
            };
      
//        console.log('выбираем мышкой область или кликаем в пустое поле');
//        console.log(eventData);
      $.ajax({
            url: '/admin/event/schedule/init-event',
            type: 'POST',
            data: {eventData : eventData},
            success: function (res) {
               // console.log(res);
            showDay(res);
            },
            error: function () {
                $('#w0').fullCalendar('unselect');
            }
        });
    }
EOF;
// кликаем по событию
$JSEventClick = <<<EOF
    function(calEvent, jsEvent, view) {

        var eventData;
            eventData = {
                id: calEvent.id,
            };
//        console.log('кликаем по событию');
//        console.log(eventData);
      $.ajax({
            url: '/admin/event/schedule/init-event',
            type: 'POST',
            data: {eventData : eventData},
            success: function (res) {
               // console.log(res);
            showDay(res);
            },
            error: function () {
                alert('Error!!!');
            }
        });
    }
EOF;
// растягиваем/сжимаем событие мышкой
$JSEventResize = <<<EOF
    function(event, delta, revertFunc, jsEvent, ui, view) {
      var eventData;
            eventData = {
                id: event.id,
                title: event.title,
                start: event.start.format(),
                end: event.end.format(),
                allDay: event.allDay,
                resourceId: event.resourceId
            };
//        console.log('растягиваем/сжимаем событие мышкой');
//        console.log(eventData);
         $.ajax({
            url: '/admin/event/schedule/refactor-event',
            type: 'POST',
            data: {eventData : eventData},
            success: function (res) {
                //  console.log(res);
            },
            error: function () {
                alert('Error!!!');
            }
        });
      }
EOF;
// перетаскиваем событие, удерживая мышкой
$JSEventDrop = <<<EOF
    function(event, delta, revertFunc, jsEvent, ui, view) {
        var eventData;
            eventData = {
                id: event.id,
                title: event.title,
                start: event.start.format(),
                end: event.end == null ? null : event.end.format(),
                allDay: event.allDay,
                resourceId: event.resourceId
            };

//     console.log('перетаскиваем событие, удерживая мышкой');
//     console.log(eventData);
      $.ajax({
            url: '/admin/event/schedule/refactor-event',
            type: 'POST',
            data: {eventData : eventData},
            success: function (res) {
            $('#w0').fullCalendar('refetchEvents', JSON);
                //  console.log(res);
            },
            error: function () {
                alert('Error!!!');
            }
        });
      }
EOF;


?>
             <div class="row">
                <div class="col-md-10">

                    <?= \edofre\fullcalendarscheduler\FullcalendarScheduler::widget([
                                'options' => [
                                    'lang' => 'ru',
                                ],
                                'header' => [
                                    'left'   => 'today prev,next',
                                    'center' => 'title',
                                    'right'  => 'agendaDay,agendaTwoDay,agendaWeek,month,listMonth',
                                ],
                                'clientOptions' => [
                                    'schedulerLicenseKey' => 'GPL-My-Project-Is-Open-Source',
                                    'selectable' => true, // разрешено выбирать область
                                    'selectHelper' => true,//Следует ли рисовать событие” заполнитель " во время перетаскивания
                                    'nowIndicator' => true, //Отображение маркера, указывающего Текущее время
                                    'minTime' => '07:00:00', // Определяет первый временной интервал, который будет отображаться для каждого дня
                                    'maxTime' => '22:00:00', 
                                    'slotDuration' => '00:15:00', // Частота отображения временных интервалов.
                                    'droppable' => true,
                                    'editable' => true,
                                    'allDaySlot' => false, // запрет на слот "весь день"
                                    'eventDurationEditable' => true, // разрешить изменение размера
                                    'eventOverlap' => true, // разрешить перекрытие событий
                                    'eventLimit' => true,
                                    'select' => new JsExpression($JSSelect),
                                    'eventClick' => new JsExpression($JSEventClick),
                                    'eventResize'=> new JsExpression($JSEventResize),
                                    'eventDrop'=> new JsExpression($JSEventDrop),
                                    'defaultDate' => date('Y.m.d H:i'),
                                    'defaultTimedEventDuration' => '02:00:00', // при перетаскивании события в календарь задается длительность события
                                    'defaultAllDayEventDuration' => [
                                        'days' => '1'// то-же при перетаскиваниив в allDay
                                    ],
                                    'aspectRatio'       => 1.8,
                                    'scrollTime'        => '00:00', // undo default 6am scrollTime
                                    'defaultView' => 'agendaWeek',
                                    'views'  => [
                                            'agendaTwoDay' => [
                                                'type' => 'agenda',
                                                'duration' => ['days' => 3],
                                                'groupByResource' => true,
                                            ],
                                    ],
                                    'resourceLabelText' => Yii::t('art/event','Event Places'),
                                           // 'resourceGroupField' => 'building',
                                    'resources' => \yii\helpers\Url::to(['/event/schedule/resources']),
                                    'events' => \yii\helpers\Url::to(['/event/schedule/calendar']),
                                    'businessHours' => [
                                                 'dow' => [ 1, 2, 3, 4, 5, 6, 7 ],
                                                 'start' => '08:00',
                                                 'end' => '21:00',
                                    ],
                                ],
]);
?>

</div>
                <div class="col-md-2">

                          <div id="color-places">
                                <h4><?= Yii::t('art/event','Event Places');?></h4>
                            <?php $data = backend\modules\event\models\EventPlace::getEventPlacesList();?>
                            <?php foreach ($data as $field) : ?>
                               <div class="fc-event"
                                    style="background-color: <?= $field['event_color']; ?>;
                                            border-color: <?= $field['event_color']; ?>;
                                            color: <?= $field['event_text_color']; ?>;">
                                    <?= $field['name']; ?></div>
                            <?php   endforeach;?>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<?php \yii\bootstrap\Modal::begin([
    'header' => '<h3 class="lte-hide-title page-title">' . Yii::t('art/event', 'Event Schedules') . '</h3>',
    'size' => 'modal-lg',
    'id' => 'event-modal',
    //'footer' => 'footer',
]);

\yii\bootstrap\Modal::end(); ?>

<?php
$js = <<<JS
function showDay(res) {

    $('#event-modal .modal-body').html(res);
    $('#event-modal').modal();
}
JS;

$this->registerJs($js);
?>

<?php $this->registerCss('

	#color-places {
		float: left;
		padding: 0 10px;
		text-align: left;
	}

	#color-places .fc-event {
		margin: 10px 0;
                padding: 0px 5px;
		//cursor: pointer;
	}
');
?>

