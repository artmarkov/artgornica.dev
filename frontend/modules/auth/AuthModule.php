<?php

namespace frontend\modules\auth;


/**
 * art module definition class
 */
class AuthModule extends \artsoft\auth\AuthModule
{
    /**
     * {@inheritdoc}
     */
 public $controllerNamespace = 'frontend\modules\auth\controllers';
    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();

        // custom initialization code goes here
    }
}