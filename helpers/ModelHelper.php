<?php
namespace app\helpers;

use Yii;


class ModelHelper
{
    protected static $transaction;
    public static function beginTransaction()
    {
        static::$transaction = Yii::$app->db->beginTransaction();
    }
    public static function rollBack()
    {
        if(!static::$transaction){
            return;
        }
        static::$transaction->rollBack();
    }
    public static function commit()
    {
        if(!static::$transaction){
            return;
        }
        static::$transaction->commit();
        static::$transaction = null;
    }
}
