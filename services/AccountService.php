<?php
namespace app\services;

use app\models\Config;
use app\models\account\LoginForm;
use app\models\account\PasswordForm;
use app\models\account\ProfileForm;
use app\models\account\RegisterForm;

class AccountService extends BaseService
{
    public function regist($post)
    {
        $model = new RegisterForm();
        
        $flag = $model->load($post);
        BaseServiceException::AssertOn($flag,'加载数据失败');
        $flag = $model->register();
        BaseServiceException::AssertWithModel($flag,$model);
    }
    public function getRegistInfo()
    {
        return Config::findOne(['type' => 'safe']);
    }
    public function login($post)
    {
        $model = new LoginForm();
        
        $flag = $model->load($post);
        BaseServiceException::AssertOn($flag,'加载数据失败');
        $flag = $model->login();
        BaseServiceException::AssertWithModel($flag,$model);
        
        return $model->callback;
    }
    public function getLoginInfo()
    {
        return Config::findOne(['type' => 'safe']);
    }
    public function setProfile($user_id, $post)
    {
        $model = ProfileForm::findModel($user_id);
        $model->scenario = 'home';
        
        $flag = $model->load($post);
        BaseServiceException::AssertOn($flag,'加载数据失败','ProfileForm');
        $flag = $model->store();
        BaseServiceException::AssertWithModel($flag,$model);
    }
    public function setPassword($user_id, $post)
    {
        $model = PasswordForm::findModel($user_id);
        $model->scenario = 'home';

        $flag = $model->load($post);
        BaseServiceException::AssertOn($flag,'加载数据失败','PasswordForm');
        $flag = $model->store();
        BaseServiceException::AssertWithModel($flag,$model);
    }
}