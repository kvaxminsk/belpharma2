<?php

if(\Yii::$app->getSession()->hasFlash('success'))
{
    echo '<div class="alert alert-success">' . \Yii::$app->getSession()->getFlash('success') . '</div>';
}

if(\Yii::$app->getSession()->hasFlash('error'))
{
    echo '<div class="alert alert-danger">' . \Yii::$app->getSession()->getFlash('error') . '</div>';
}

if(\Yii::$app->getSession()->hasFlash('ie'))
{
    echo '<div class="alert alert-danger">' . \Yii::$app->getSession()->getFlash('ie') . '</div>';
}