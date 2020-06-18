<?php
namespace app\controllers\home;

use app\helpers\ControllerHelper;
use app\services\ModuleService;

class ModuleController extends PublicController
{
    /**
     * 添加模块
     * @param $project_id 项目ID
     * @return array|string
     */
    public function actionCreate($project_id)
    {
        ControllerHelper::WrapExceptionOnce(ModuleService::G(),'添加成功');
        $ret = ModuleService::G()->create($project_id, ControllerHelper::POST());
        if($ret){
            return $ret;
        }
        return $this->display('create');
    }

    /**
     * 更新模块
     * @param $id 模块ID
     * @return array|string
     */
    public function actionUpdate($id)
    {
        ControllerHelper::WrapExceptionOnce(ModuleService::G(),'编辑成功');
        $ret = ModuleService::G()->update($id, ControllerHelper::POST());
        if($ret){
            return $ret;
        }
        $model = ModuleService::G()->getDataForUpdate($id);
        return $this->display('update', ['module' => $model]);
    }

    /**
     * 删除模块
     * @param $id 模块ID
     * @return array|string
     */
    public function actionDelete($id)
    {
        ControllerHelper::WrapExceptionOnce(ModuleService::G(),'删除成功');
        $ret = ModuleService::G()->delete($id, ControllerHelper::POST());
        if($ret){
            return $ret;
        }
        $model = ModuleService::G()->getDataForDelete($id);
        return $this->display('update', ['module' => $model]);
    }


}
