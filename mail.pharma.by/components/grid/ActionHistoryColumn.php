<?php

namespace app\components\grid;

use yii\helpers\Html;
use yii\grid\ActionColumn;
use app\modules\main\models\Orders;

/**
 * Description of ActionHistoryColumn
 *
 * @author Robert Kuznetsov <RK at buildinggame.ru>
 */
class ActionHistoryColumn extends ActionColumn
{
    public $header = 'Действие';
    public $headerOptions = [
        'class' => 'action-history-column',
    ];
    public $template = '{repeat}<br>{change}<br>{remove}';
    
    public function initDefaultButtons() {
        if (!isset($this->buttons['repeat'])) {
            $this->buttons['repeat'] = function ($url, $model, $key) {
                $options = array_merge([
                    'class' => 'repeat'
                ], $this->buttonOptions);
                $model->status == Orders::STATUS_SENDED ? $text = 'Отправить повторно' : $text = 'Отправить';
                return Html::a($text, $url, $options);
            };
        }
        if(!isset($this->buttons['change'])) {
            $this->buttons['change'] = function ($url, $model, $key) {
                $options = array_merge([
                    'class' => 'change'
                ], $this->buttonOptions);
                return Html::a('Изменить', ['/main/orderedproduct/change', 'id' => $model->id], $options);
            };
        }
        if(!isset($this->buttons['remove'])) {
            $this->buttons['remove'] = function ($url, $model, $key) {
                $options = array_merge([
                    'class' => 'remove',
                    'data' => [
                        'method' => 'post',
                        'confirm' => 'Вы точно хотите удалить заказ из истории?'
                    ]
                ], $this->buttonOptions);
                return Html::a('Удалить', ['/main/orderedproduct/remove', 'id' => $model->id], $options);
            };
        }
    }
}
