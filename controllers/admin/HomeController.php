<?php
namespace app\controllers\admin;

use yii\helpers\Url;
use app\services\AdminService;
use app\services\SessionService;
use app\services\BaseServiceException;

class HomeController extends PublicController
{
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }
    /**
     * 后台主页
     * @return string|\yii\web\Response
     * @throws \yii\db\Exception
     */
    public function actionIndex()
    {
        if(SessionService::G()->isGuest()){
            return $this->redirect(['home/account/login', 'callback' => Url::current()]);
        }
        $data=AdminService::G()->getDataForHome();
        return $this->display('index', $data);
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
