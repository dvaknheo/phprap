<?php
namespace app\services;

use Yii;
class CacheService extends BaseService
{
    public function installStep($new=null)
    {
        if($new!==null){
            Yii::$app->cache->set('step',$new);
            return $new;
        }
        return Yii::$app->cache->get('step');
    }
    
}