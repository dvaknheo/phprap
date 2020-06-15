<?php
namespace app\controllers\home;

use Yii;
use app\serivces\HistoryService;

class HistoryController extends PublicController
{
    /**
     * 登录历史
     * @param $project_id
     * @return array|string
     */
    public function actionLogin()
    {
        $params = Yii::$app->request->queryParams;
        $user_id = Yii::$app->user->identity->id;

        $model = HistoryService::G()->searchLoginLog($user_id,$params);

        return $this->display('login', ['model' => $model]);
    }

    /**
     * 申请历史
     * @return string
     */
    public function actionApply()
    {
        $params = Yii::$app->request->queryParams;
        $user_id = Yii::$app->user->identity->id;

        $model = HistoryService::G()->searchAppley($user_id,$params);

        return $this->display('apply', ['model' => $model]);
    }

}
