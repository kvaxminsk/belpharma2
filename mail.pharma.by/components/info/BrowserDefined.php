<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\components\info;
use Yii;

/**
 * Description of BrowserDefined
 *
 * @author mr
 */
class BrowserDefined {
    protected static function getIE()
    {
        $agent = $_SERVER['HTTP_USER_AGENT'];
        preg_match("/(MSIE|Opera|Firefox|Chrome|Version|Opera Mini|Netscape|Konqueror|SeaMonkey|Camino|Minefield|Iceweasel|K-Meleon|Maxthon)(?:\/| )([0-9.]+)/", $agent, $browser_info); // регулярное выражение, которое позволяет отпределить 90% браузеров
        if(!empty($browser_info))
            list(,$browser,$version) = $browser_info; // получаем данные из массива в переменную
        if (preg_match("/Opera ([0-9.]+)/i", $agent, $opera)) return 'Opera '.$opera[1]; // определение _очень_старых_ версий Оперы (до 8.50), при желании можно убрать
        if (isset($browser) && $browser == 'MSIE') { // если браузер определён как IE
                preg_match("/(Maxthon|Avant Browser|MyIE2)/i", $agent, $ie); // проверяем, не разработка ли это на основе IE
                return $version; // иначе просто возвращаем IE и номер версии
        }
        return false;
    }
    
    public static function isIE()
    {
        $version = self::getIE();
        if($version != false && ($version=='8' || $version == '7' || $version = '6' || $version || '5')) {
            Yii::$app->session->setFlash('ie', 'У Вас браузер Internet Explorer версии 8 или ниже. Обновите версию браузера или используйте другой.');
        }
    }
}
