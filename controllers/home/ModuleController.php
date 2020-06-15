<?php
namespace app\controllers\home;

use Yii;
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
        $ret = ControllerHelper::AjaxPost('添加成功',function($post)use($project_id) {
            ModuleService::G()->create($project_id,$post);
        });
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
        $ret = ControllerHelper::AjaxPost('编辑成功',function($post)use($id) {
            ModuleService::G()->update($id,$post);
        });
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
        $ret = ControllerHelper::AjaxPost('删除成功',function($post)use($id) {
            ModuleService::G()->delete($id,$post);
        });
        if($ret){
            return $ret;
        }
        $model = ModuleService::G()->getDataForDelete($id);
        return $this->display('update', ['module' => $model]);
    }


}
