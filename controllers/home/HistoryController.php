<?php
namespace app\controllers\home;

use app\helpers\ControllerHelper;
use app\services\HistoryService;
use app\services\SessionService;

class HistoryController extends PublicController
{
    /**
     * 登录历史
     * @param $project_id
     * @return array|string
     */
    public function actionLogin()
    {
        $params = ControllerHelper::REQUEST();
        $user_id = SessionService::G()->getCurrentUid();

        $model = HistoryService::G()->searchLoginLog($user_id,$params);

        return $this->display('login', ['model' => $model]);
    }

    /**
     * 申请历史
     * @return string
     */
    public function actionApply()
    {
        $params = ControllerHelper::REQUEST();
        $user_id = SessionService::G()->getCurrentUid();

        $model = HistoryService::G()->searchAppley($user_id,$params);

        return $this->display('apply', ['model' => $model]);
    }

}
