<?php
namespace app\controllers\admin;

use app\helpers\ControllerHelper;
use app\services\AdminService;

class SettingController extends PublicController
{
    /**
     * 基础设置
     *
     * @return string
     */
    public function actionApp()
    {
        ControllerHelper::WrapExceptionOnce(AdminService::G(),'保存成功');
        $ret = AdminService::G()->setSettingApp(ControllerHelper::POST());
        if($ret){
            return $ret;
        }
    	$config = AdminService::G()->getSettingApp();
        return $this->display('app', ['config' => $config]);
    }

    /**
     * 邮箱设置
     * @return array|string
     */
    public function actionEmail()
    {
        ControllerHelper::WrapExceptionOnce(AdminService::G(),'保存成功');
        $ret = AdminService::G()->setSettingEmail(ControllerHelper::POST());
        if($ret){
            return $ret;
        }
        $config = AdminService::G()->getSettingEmail();
        return $this->display('email', ['config' => $config]);
    }

    /**
     * 安全设置
     * @return array|string
     */
    public function actionSafe()
    {
        ControllerHelper::WrapExceptionOnce(AdminService::G(),'保存成功');
        $ret = AdminService::G()->setSettingSafe($post);
        if($ret){
            return $ret;
        }
        $config = AdminService::G()->getSettingSafe();
        return $this->display('safe', ['config' => $config]);
    }
}
