<?php
namespace app\controllers\home;

use Yii;
use app\helpers\ControllerHelper;
use app\services\EnvService;

class EnvController extends PublicController
{
    /**
     * 创建环境
     * @param $project_id 项目id
     * @return array|string
     */
    public function actionCreate($project_id)
    {
        ControllerHelper::WrapExceptionOnce(EnvService::G(),'创建成功');
        $ret = EnvService::G()->create($project_id, ControllerHelper::POST());
        if($ret){
            return $ret;
        }
        $model = EnvService::G()->getDataForCreate($project_id);
        return $this->display('create', ['env' => $model]);
    }

    /**
     * 更新环境
     * @param $id 环境ID
     * @return array|string
     */
    public function actionUpdate($id)
    {
        ControllerHelper::WrapExceptionOnce(EnvService::G(),'编辑成功');
        $ret = EnvService::G()->update($id, ControllerHelper::POST());
        if($ret){
            return $ret;
        }
        
        $model = EnvService::G()->getDataForUpdate($id);
        return $this->display('update', ['env' => $model]);
    }

    /**
     * 删除环境
     * @param $id 环境ID
     * @return array|string
     */
    public function actionDelete($id)
    {
        ControllerHelper::WrapExceptionOnce(EnvService::G(),'删除成功');
        $ret = EnvService::G()->delete($id, ControllerHelper::POST());
        if($ret){
            return $ret;
        }
        $model = EnvService::G()->getDataForDelete($id);
        return $this->display('delete', ['env' => $model]);
    }

}
