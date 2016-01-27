<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\components\events;

use yii\base\Event;

/**
 * Description of OrderEvent
 *
 * @author mr
 */
class OrderEvent extends Event 
{
    public $orderedProduct;
}
