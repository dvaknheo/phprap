<?php
namespace app\helpers;

use Yii;
use app\services\BaseServiceException;
use yii\web\Response;


class ControllerHelper
{
    protected static $ExtJsonData=[];
    
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
        if(isset($key)){
            return Yii::$app->request->post($key);
        }else{
            return Yii::$app->request->post();
        }
    }
    public static function WrapExceptionOnce($object)
    {
        //TODO
    }
}