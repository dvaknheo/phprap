<?php
namespace app\services;

class BaseService
{
    public function G()
    {
        static $instance;
        $instance = $instance ?? new static();
        
        return $instance;
    }
    
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
