<?php
namespace app\services;
use app\helpers\ServiceHelper;

class BaseServiceException extends \Exception
{
    protected $label;
    protected $model;
    public static function ThrowOn($flag,$message)
    {
        if(!$flag){
            return;
        }
        ServiceHelper::rollBack();
        throw (new static($message));
    }
    public static function AssertOn($flag,$message,$modelName=null)
    {
        if($flag){
            return;
        }
        ServiceHelper::rollBack();
        throw (new static($message))->setModel($modelName,false);
    }
    public static function AssertWithModel($flag,$model)
    {
        if($flag){
            return;
        }
        ServiceHelper::rollBack();
        throw (new static())->attachModel($model);
    }
    public function setLabel($label)
    {
        $this->label = $label;
        return  $this;
    }
    public function setModel(?string $model,$trim = true)
    {
        $this->model=$mode;
        return $this;
    }
    public function attachModel($model)
    {
        if($model){
            $this->message = $model->getErrorMessage();
            $this->label = $model->getErrorLabel();
        }
        return  $this;
    }
    public function returnArray()
    {
        $ret = ['status' => 'error', 'message' => $this->getMessage()];
        if(!empty($this->model)){
            $ret['model'] = $this->model;
        }
        if(!empty($this->label)){
            $ret['label'] = $this->label;
        }
        
        return $ret;
    }
}