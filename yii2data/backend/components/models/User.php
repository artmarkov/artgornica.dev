<?php

namespace backend\components\models;

class User extends \artsoft\models\User
{
 /* Геттер для полного имени */

    public function getFullName() {
        return $this->last_name . ' ' . $this->first_name . ' [' . $this->username . ']';
    }
    
}
