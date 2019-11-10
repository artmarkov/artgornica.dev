<?php
use yii\helpers\Html;
use yii\helpers\Url;
?>
<div class="widget">

    <h4 class="uppercase"><?= Yii::t('art/post', 'Blog search') ?></h4>

<?= Html::beginForm(Url::to(['/site/search']), 'get', ['class' => '']) ?>
        <div class="input-group">
          <?= Html::textInput('q', $text, ['class' => 'form-control', 'placeholder' => 'Поиск...']) ?>
          <span class="input-group-btn">
            <?= Html::submitButton('<i class="fa fa-search"></i>', ['class' => 'btn btn-primary']) ?>
          </span>
        </div><!-- /input-group -->
<?= Html::endForm() ?>
    
</div>
