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
        if (ControllerHelper::NotAjax()) {
            $config = AdminService::G()->getSettingApp();
            return $this->display('app', ['config' => $config]);
        }
        ControllerHelper::WrapExceptionOnce(AdminService::G(), '保存成功');
        $ret = AdminService::G()->setSettingApp(ControllerHelper::POST());
        ControllerHelper::returnData($ret);
    }

    /**
     * 邮箱设置
     * @return array|string
     */
    public function actionEmail()
    {
        if (ControllerHelper::NotAjax()) {
            $config = AdminService::G()->getSettingEmail();
            return $this->display('email', ['config' => $config]);
        }
        ControllerHelper::WrapExceptionOnce(AdminService::G(), '保存成功');
        $ret = AdminService::G()->setSettingEmail(ControllerHelper::POST());
        ControllerHelper::returnData($ret);
    }

    /**
     * 安全设置
     * @return array|string
     */
    public function actionSafe()
    {
        if (ControllerHelper::NotAjax()) {
            $config = AdminService::G()->getSettingSafe();
            return $this->display('safe', ['config' => $config]);
        }
        ControllerHelper::WrapExceptionOnce(AdminService::G(), '保存成功');
        $ret = AdminService::G()->setSettingSafe(ControllerHelper::Post());
        ControllerHelper::returnData($ret);
    }

}
