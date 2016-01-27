<?php

namespace app\components\widgets;

use yii\base\Widget;

/**
 * Description of AlertWidget
 *
 * @author Robert Kuznetsov <RK at buildinggame.ru>
 */
class AlertWidget extends Widget{
    public function init() {
        parent::init();
    }
    
    public function run() {
        parent::run();
        return $this->render('alert');
    }
}
