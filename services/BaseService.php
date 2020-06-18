<?php
namespace app\services;

class BaseService
{
    protected static $_instances = [];
    /**
     * 
     * @param type $object
     * @return \static
     */
    public static function G($object = null)
    {
        if (defined('__SINGLETONEX_REPALACER')) {
            $callback = __SINGLETONEX_REPALACER;
            return ($callback)(static::class, $object);
        }
        if ($object) {
            self::$_instances[static::class] = $object;
            return $object;
        }
        $me = self::$_instances[static::class] ?? null;
        if (null === $me) {
            $me = new static();
            self::$_instances[static::class] = $me;
        }
        
        return $me;
    }
    protected $successMessage;
    protected function setSuccessMessage($successMessage)
    {
        $this->successMessage = $successMessage;
    }
    public function getSuccessMessage()
    {
        return $this->successMessage;
    }
    //
    public function  doModel($model,$post)
    {
        if(!$model->load($post)){
            throw (new BaseServiceException())->setModel($model);
        }
        if (!$model->store()) {
            throw (new BaseServiceException())->setLabel($model->getErrorLabel());
        }
    }
}
