<?php
namespace app\controllers\home;

use app\services\AccountService;
use yii\base\DynamicModel;
class TestController extends PublicController
{
    public $checkLogin = false; //stop login;
    public function actionIndex()
    {
        $this->actionTest();
    }
    public function actionTest()
    {
        $email="xx@xx.com";
        $name="name";
        $ext="eeeeeeeeeeeeeeeeeext";
        $model = DynamicModel::validateData(['name'=>$name,'email'=>$email,'ext'=>$ext], [
        [['name', 'email'], 'string', 'max' => 128],
        ['email', 'email'],
        ['ext',function ($attribute, $params,$v) {
            var_dump(func_get_args());
            return true;
          }, 'when' => function($model, $attribute){
               var_dump(func_get_args());
                return true;
            }]
        ]);

        if ($model->hasErrors()) {
            var_dump("failed");
            // 验证失败
        } else {
            var_dump("OK");
            // 验证成功
        }
        
        exit;
        return;
        $post = array (
          'csrf-phprap' => '3hz8MpyGCHZv4ebH_FAmYHV1RJ3kD38GULtcQX0HhTWcQ89kz_JADCvQvvWWA3EWTAct8YNoNDEI3GQmNE3vbw==',
          'RegisterForm' => 
          array (
            'email' => 't1@xx.com',
            'name' => 't1',
            'password' => '12345678',
            'verifyCode' => 'fsdf',
          ),
        );
        try{
            \app\services\AccountService::G()->regist($post);
        }catch(\app\services\BaseServiceException $ex){
            var_export($ex->returnArray());
        }
    }
}
