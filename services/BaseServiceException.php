<?php
namespace app\services;

class BaseServiceException extends \Exception
{
    protected $label;
    protected $model;
    public static function ThrowOn($flag,$message)
    {
        if(!$flag){
            return;
        }
        throw (new static($message));
    }
    public static function AssertOn($flag,$message,$modelName=null)
    {
        if($flag){
            return;
        }
        throw (new static($message))->setModel($modelName,false);
    }
    public static function AssertWithModel($flag,$model)
    {
        if($flag){
            return;
        }
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
        $this->message = $model->getErrorMessage();
        $this->label = $model->getErrorLabel();
        
        return  $this;
    }
    public function returnArray()
    {
        $ret = ['status' => 'error', 'message' => $this->getMessage()];
        if(isset($this->model)){
            $ret['model'] = $this->model;
        }
        if(isset($this->label)){
            $ret['model'] = $this->label;
        }
        
        return $ret;
    }
}