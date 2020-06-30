<?php
namespace app\controllers\admin;

use app\helpers\ControllerHelper;
use app\services\AdminService;

class UserController extends PublicController
{
    /**
     * 成员列表
     * @return string
     */
    public function actionIndex()
    {
        $params = ControllerHelper::REQUEST();
        $data = AdminService::G()->searchUser($params);

        return $this->display('index', $data);
    }

    /**
     * 编辑账号
     * @return string
     */
    public function actionProfile($id)
    {
        if (ControllerHelper::NotAjax()) {
            $model = AdminService::G()->getUserProfile($id);
            return $this->display('profile', ['user' => $model]);
        }
        ControllerHelper::WrapExceptionOnce(AdminService::G());
        $ret=AdminService::G()->setUserProfile($id,ControllerHelper::Post());
        return ControllerHelper::returnData($ret);
    }

    /**
     * 修改密码
     * @return array|string
     */
    public function actionPassword($id)
    {
        if (ControllerHelper::NotAjax()) {
            $model = AdminService::G()->getUserPassword($id);
            return $this->display('password', ['user' => $model]);
        }
        ControllerHelper::WrapExceptionOnce(AdminService::G(),'保存成功');
        $ret = AdminService::G()->setUserPassword($id,ControllerHelper::Post());
        return ControllerHelper::returnData($ret);
    }
}
