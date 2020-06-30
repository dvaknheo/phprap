<?php
namespace app\controllers\home;

use app\services\AccountService;

class TestController extends PublicController
{
    public $checkLogin = false; //stop login;
    public function actionIndex()
    {
        $this->actionTest();
    }
    public function actionTest()
    {
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
