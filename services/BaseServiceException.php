<?php
namespace app\services;

use Yii;
class BaseServiceException extends \Exception
{
    protected $label;
    protected $model;
    public static function ThrowOn($flag,$message)
    {
    }
    public static function ThrowWithModel($flag,$message)
    {
    
    }
    
    public function setLabel($label)
    {
        $this->label = $label;
        return  $this;
    }
    public function setModel(string $model,$trim = true)
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