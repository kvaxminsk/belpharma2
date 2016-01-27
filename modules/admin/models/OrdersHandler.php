<?php

namespace app\modules\admin\models;

use Yii;
use app\modules\main\models\Orders;
use app\modules\admin\models\User;

/**
 * This is the model class for table "orders".
 *
 * @property integer $id
 * @property integer $status
 * @property integer $user_id
 * @property string $created_at
 * @property integer $repeated
 */
class OrdersHandler extends Orders
{
    public function getContragentName()
    {
        $user = User::findOne($this->user_id);
        if(!empty($user)) {
            return $user->name;
        } else {
            return '(пусто)';
        }
    }
    
    public function getContragentCod()
    {
        $user = User::findOne($this->user_id);
        if(!empty($user)) {
            return $user->cod;
        } else {
            return '(пусто)';
        }
    }
}
