<?php
namespace app\controllers\admin;

use app\helpers\ControllerHelper;
use app\services\AdminService;

class ProjectController extends PublicController
{
    /**
     * 搜索项目
     * @return string
     */
    public function actionIndex()
    {
        $params = ControllerHelper::REQUEST();
        $model = AdminService::G()->searchProject($params);
        return $this->display('index', ['project' => $model]);
    }

    /**
     * 回收站
     * @return string
     * @throws \Exception
     */
    public function actionRecycle()
    {
        $params = ControllerHelper::REQUEST();
        $model = AdminService::G()->searchProjectRecycled($params);
        return $this->display('recycle', ['project' => $model]);
    }

    /**
     * 删除项目
     * @param $id
     * @return array|string
     */
    public function actionDelete($id)
    {
        ControllerHelper::WrapExceptionOnce(AdminService::G(),'删除成功');
        $ret = AdminService::G()->deleteProject($id, ControllerHelper::POST());
        if($ret){
            return $ret;
        }
        $model = AdminService::G()->getProejctForDelete($id);
        return $this->display('delete', ['project' => $model]);
    }

    /**
     * 删除项目
     * @param $id
     * @return array|string
     */
    public function actionRecover($id)
    {
        ControllerHelper::WrapExceptionOnce(AdminService::G(),'恢复成功');
        $ret = AdminService::G()->recoverProject($id, ControllerHelper::POST());
        if($ret){
            return $ret;
        }
        $model = AdminService::G()->getProejctForRecycle($id);
        return $this->display('recover', ['project' => $model]);
    }

}
