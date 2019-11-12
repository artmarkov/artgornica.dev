<?php
use artsoft\media\widgets\TinyMce;
?> 
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-body">

                <?= $form->field($model, 'assignment')->widget(TinyMce::className()); ?>

            </div>

        </div>
    </div>
</div>

