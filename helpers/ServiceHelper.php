<?php
namespace app\helpers;

class ServiceHelper
{
    public static function beginTransaction()
    {
        return ModelHelper::beginTransaction();
    }
    public static function rollBack()
    {
        return ModelHelper::rollBack();
    }
    public static function commit()
    {
        return ModelHelper::commit();
    }
}
