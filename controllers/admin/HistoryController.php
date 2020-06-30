<?php
namespace app\controllers\admin;

use app\services\AdminService;
use app\helpers\ControllerHelper;
class HistoryController extends PublicController
{
    /**
     * 登录历史
     * @param $project_id
     * @return array|string
     */
    public function actionLogin()
    {
        $data = AdminService::G()->getDataForLoginHistory(ControllerHelper::REQUEST());

        return $this->display('login', $data);
    }
}
