<?php
namespace app\services;

use Yii;
class CacheService
{
    public function G()
    {
        static $instance;
        $instance = $instance ?? new static();
        
        return $instance;
    }
    
    public function installStep($new=null)
    {
        if($new!==null){
            Yii::$app->cache->set('step',$new);
            return $new;
        }
        return Yii::$app->cache->get('step');
    }
    
}