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
        $ret = ControllerHelper::AjaxPost('创建成功',function($post)use($project_id) {
            EnvService::G()->create($project_id,$post);
        });
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
        $request = Yii::$app->request;
        $ret = ControllerHelper::AjaxPost('编辑成功',function($post)use($id) {
            EnvService::G()->update($id,$post);
        });
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
        $ret = ControllerHelper::AjaxPost('删除成功',function($post)use($id) {
            EnvService::G()->delete($id,$post);
        });
        if($ret){
            return $ret;
        }
        $model = EnvService::G()->getDataForDelete($id);
        return $this->display('delete', ['env' => $model]);
    }

}
