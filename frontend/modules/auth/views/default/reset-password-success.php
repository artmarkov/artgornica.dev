<?php

/**
 * @var yii\web\View $this
 */

$this->title = Yii::t('art/auth', 'Password recovery');
?>
<div class="password-recovery-success">
    <div class="container">
        <div class="alert alert-success">
            <?= '<i class="fa fa-check-circle"></i>' . Yii::t('art/auth', 'Check your E-mail for further instructions') ?>
        </div>
    </div>
</div>
