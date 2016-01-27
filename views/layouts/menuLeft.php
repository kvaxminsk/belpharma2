<?php
use yii\helpers\Html;
$menu = isset($this->params['menu']) ? $this->params['menu'] : null;
if (Yii::$app->user->isGuest != true) {
    isset($menu) && $menu == 1 ? $class = 'active' : $class = '';
    echo '<div class="nav-el">' . Html::a('Остатки товаров', ['/main/products'], ['class' => $class]) . '</div>';
}
if (!Yii::$app->user->isGuest && Yii::$app->user->identity->role == 1) {
    isset($menu) && $menu == 2 ? $class = 'active' : $class = '';
    echo '<div class="nav-el">' . Html::a('Заказы', ['/admin/ordershandler'], ['class' => $class]) . '</div>';
}
if (!Yii::$app->user->isGuest && Yii::$app->user->identity->role == 2) {
    isset($menu) && $menu == 3 ? $class = ' active' : $class = '';
    $count = app\modules\main\models\OrderedProduct::find()->countOrdered();
    echo '<div class="nav-el">' . Html::a('Оформить заказ (' . $count . ')', ['/main/orderedproduct/checkout'], ['class' => "ordered-products$class"]) . '</div>';
}
if (!Yii::$app->user->isGuest && Yii::$app->user->identity->role == 2) {
    isset($menu) && $menu == 4 ? $class = 'active' : $class = '';
    echo '<div class="nav-el">' . Html::a('История заказов', ['/main/orders/history'], ['class' => $class]) . '</div>';
}
if (!Yii::$app->user->isGuest && Yii::$app->user->identity->role == 2) {
    isset($menu) && $menu == 5 ? $class = 'active' : $class = '';
    echo '<div class="nav-el">' . Html::a('Файлы', ['/main/files'], ['class' => $class]) . '</div>';
}
if (!Yii::$app->user->isGuest && Yii::$app->user->identity->role == 1) {
    isset($menu) && $menu == 6 ? $class = 'active' : $class = '';
    echo '<div class="nav-el">' . Html::a(Yii::t('app', 'CONTRAGENTS_TITLE'), ['/admin/users/contragents'], ['class' => $class]) . '</div>';
}
if (!Yii::$app->user->isGuest && Yii::$app->user->getId() == 1) {
    isset($menu) && $menu == 7 ? $class = 'active' : $class = '';
    echo '<div class="nav-el">' . Html::a('Администраторы', ['/admin/users/administrators'], ['class' => $class]) . '</div>';
}
if (!Yii::$app->user->isGuest && Yii::$app->user->identity->role == 1) {
    isset($menu) && $menu == 8 ? $class = 'active' : $class = '';
    echo '<div class="nav-el">' . Html::a('Импорт в БД', ['/admin/import'], ['class' => $class]) . '</div>';
}
if (!Yii::$app->user->isGuest && Yii::$app->user->identity->role == 1) {
    isset($menu) && $menu == 9 ? $class = 'active' : $class = '';
    echo '<div class="nav-el">' . Html::a('Настройка', ['/admin/settings'], ['class' => $class]) . '</div>';
}
if (Yii::$app->user->isGuest) {
    echo '<div class="nav-el">' . Html::a(Yii::t('app', 'NAV_LOGIN'), ['/user/default/login'], ['class' => '']) . '</div>';
} else {
    echo '<div class="nav-el last">' . Html::a(Yii::t('app', 'NAV_LOGOUT') . ' (' . Yii::$app->user->identity->username . ')', ['/user/default/logout'], ['class' => '', 'data' => ['method' => 'post']]) . '</div>';
}
?>