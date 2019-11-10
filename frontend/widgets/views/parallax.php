<?php

use artsoft\helpers\Html;
?> 
<!-- PARALLAX  parallax margin-top80 parallax-init, parallax delayed-->
<div style="background: <?= $parallax->bg_color ?>;" >
    <section id="paralax" class="<?= $parallax->parallax_class ?>" data-stellar-background-ratio="<?= $parallax->background_ratio ?>"
             style="background-image: url('<?= $parallax->bg_image ?>');">
        <!--<span class="overlay"></span>-->

        <div class="container">

            <div class="row">
                <!-- left content -->
                <div class="col-md-7 animation_fade_in">
                    <?= $parallax->content ?>

                    <!-- Countdown -->
                    <?php if ($parallax->countdown != 0 && $parallax->start_timestamp > time()): ?>
                        <div id="countdown" class="nopadding">
                            <h3 class="nopadding nomargin"><?= $parallax->countdown_prompt ?></h3>
                            <div class="countdown-widget nopadding" 
                                 id="countdown-widget" 
                                 data-time="<?= \Yii::$app->formatter->asDatetime($parallax->start_timestamp, "php:Y.m.d H:i:s"); ?>">
                            </div>
                        </div>
                    <?php endif; ?>
                    <!-- /Countdown -->

                    <div class="padding50">
                        <?= Html::a('<i class="' . $parallax->btn_icon . '"></i>' . Yii::t('art/section', '' . $parallax->btn_name . '') . '</span>', [$parallax->url], ['class' => $parallax->btn_class]) ?>
                    </div> 
                </div>

                <!-- right image -->
                <div class="col-md-5 animation_fade_in">
                    <img class="visible-md visible-lg img-responsive pull-right" src="<?= $parallax->content_image ?>">
                </div>
            </div>
        </div>

    </section>
</div>
