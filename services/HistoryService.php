<?php
namespace app\services;

use app\models\Apply;
use app\models\LoginLog;


class HistoryService extends BaseService
{
    public function searchLoginLog($user_id,$params)
    {
        $params['user_id'] = $user_id;
        $model = LoginLog::findModel()->search($params);
        $ret = [
            'model' => $model,
            'params' => $model->params,
        ];
        return $ret;
    }
    public function searchApply($user_id,$params)
    {
        $params['creater_id'] = $user_id;
        $params['pass_status'] = Apply::PASS_STATUS;
        $params['refuse_status'] = Apply::REFUSE_STATUS;
        $params['order_by'] = 'checked_at desc';

        $model = Apply::findModel()->search($params);
        $ret = [
            'model' => $model,
            'params' => $model->params,
        ];
        return $ret;
    }
}