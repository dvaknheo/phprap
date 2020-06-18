<?php
namespace app\services;

use Yii;
class SessionService extends BaseService
{
    public function isGuest()
    {
        return Yii::$app->user->isGuest;
    }
    public function getCurrentUid()
    {
        return Yii::$app->user->identity->id;
    }
}