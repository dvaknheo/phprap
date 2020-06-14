<?php
namespace app\controllers\admin;

use Yii;
use app\services\AdminService;

class HistoryController extends PublicController
{
    /**
     * 登录历史
     * @param $project_id
     * @return array|string
     */
    public function actionLogin()
    {
        $model = AdminService::G()->getDataForLoginHistory(Yii::$app->request->queryParams);

        return $this->display('login', ['model' => $model]);
    }
}
