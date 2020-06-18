<?php
namespace app\controllers\home;

use Yii;
use yii\helpers\Url;
use app\helpers\ControllerHelper;
use app\services\AccountService;


class AccountController extends PublicController
{
    public $checkLogin = false;

    /**
     * 会员注册
     * @return array|string
     */
    public function actionRegister()
    {
        $ret = ControllerHelper::AjaxPost('注册成功',function() {
            AccountService::G()->regist(ControllerHelper::POST());
            ControllerHelper::AjaxPostExtData(['callback' => Url::toRoute(['project/select'])]);
        });
        if($ret){
            return $ret;
        }
        $config = AccountService::G()->getRegistInfo();
        return $this->display('register', ['config' => $config]);
    }

    /**
     * 会员登录
     * @return array|string|Response
     */
    public function actionLogin()
    {
        // 已登录用户直接挑转到项目选择页
        if(!SessionService::G()->isGuest()){
            return $this->redirect(['home/project/select']);
        }
        $ret = ControllerHelper::AjaxPost('登录成功',function() {
            $callback = AccountService::G()->login(ControllerHelper::POST());
            $callback = $callback ? $callback : Url::toRoute(['home/project/select']);
            ControllerHelper::AjaxPostExtData(['callback' => $callback]);
        });
        if($ret){
            return $ret;
        }

        $config = AccountService::G()->getLoginInfo();
        return $this->render('login', ['callback' => Yii::$app->request->get('callback', ''), 'config' => $config]);
    }

    /**
     * 退出登录
     * @return Response
     */
    public function actionLogout()
    {
        if (SessionService::G()->isGuest() || Yii::$app->user->logout()) {
            return $this->redirect(['account/login']);
        }
    }

    /**
     * 个人主页
     * @return string
     */
    public function actionHome()
    {
        if(SessionService::G()->isGuest()) {
            return $this->redirect(['home/account/login','callback' => Url::current()]);
        }
        return $this->display('home');
    }

    /**
     * 个人资料
     * @return array|string
     */
    public function actionProfile()
    {
        if (SessionService::G()->isGuest()) {
            return $this->redirect(['home/account/login','callback' => Url::current()]);
        }
        $user_id=SessionService::G()->getCurrentUid();
        
        ControllerHelper::WrapExceptionOnce(AccountService::G(),'修改成功');
        $ret = AccountService::G()->setProfile($user_id, ControllerHelper::POST());
        if($ret){
            return $ret;
        }
        return $this->display('profile');
    }

    /**
     * 修改密码
     * @return array|string
     */
    public function actionPassword()
    {
        if (SessionService::G()->isGuest()) {
            return $this->redirect(['home/account/login','callback' => Url::current()]);
        }
        $user_id = SessionService::G()->getCurrentUid();
        ControllerHelper::WrapExceptionOnce(AccountService::G(),'密码修改成功，请重新登录');

        $ret = AccountService::G()->setPassword($user_id, ControllerHelper::POST());
        if($ret){
            return $ret;
        }
        return $this->display('password');
    }

}
