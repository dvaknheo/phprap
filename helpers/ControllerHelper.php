<?php
namespace app\helpers;

use Yii;
use app\services\BaseServiceException;
use yii\web\Response;


class ControllerHelper
{
    public static $ExtJsonData=[];
    
    public static function REQUEST()
    {
        return Yii::$app->request->queryParams;
    }
    public static function IsAjax()
    {
        $request = Yii::$app->request;
        if($request->isPost){
            Yii::$app->response->format = Response::FORMAT_JSON;
            return true;
        }
        return false;
    }
    //*/
    public static function AjaxPostExtData($data)
    {
        static::$ExtJsonData = $data;
        $ret = ['status' => 'success', 'message' =>''];
        $ret = array_merge($ret, static::$ExtJsonData);
        return $ret;
    }
    public static function AjaxPost($message,$callback)
    {
        $request = Yii::$app->request;
        if(!$request->isPost){
            return null;
        }
        $post=$request->post();
        Yii::$app->response->format = Response::FORMAT_JSON;
        try{
            static::$ExtJsonData=[];
            ($callback)($post);
            $ret = ['status' => 'success', 'message' => $message];
            if(static::$ExtJsonData){
                $ret = array_merge($ret, static::$ExtJsonData);
            }
            return $ret;
        }catch(BaseServiceException $ex){
            return $ex->returnArray();
        }
    }
    public static function Post($key=null)
    {
        return Yii::$app->request->post($key);
    }
    public static function WrapExceptionOnce($object,$successMessage=null)
    {
        $class=get_class($object);
        $class::G((new Proxy())->setup($class,$object,$successMessage));
    }
}
class Proxy
{
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
    protected $class;
    protected $object;
    protected $successMessage=null;
    
    public function setup($class,$object,$successMessage)
    {
        $this->class=$class;
        $this->object=$object;
        $this->object=$object;
        
        return $this;
    }
    public function __call($func,$args)
    {
        $request = Yii::$app->request;
        if(!$request->isPost){
            $this->class::G($this->object);
            $this->object=null;
            return null;
        }
        try{
            Yii::$app->response->format = Response::FORMAT_JSON;
            ([$this->object,$func])(...$args);
            $successMessage=$successMessage??$this->object->getSuccessMessage();
            $this->class::G($this->object);
            $this->object=null;
            $ret = ['status' => 'success', 'message' => $successMessage];
            return $ret;
            
        }catch(BaseServiceException $ex){
            return $ex->returnArray();
        }        
    }
}