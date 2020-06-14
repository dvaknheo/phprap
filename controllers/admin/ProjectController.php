<?php
namespace app\controllers\admin;

use Yii;
use yii\web\Response;

use app\helpers\ControllerHelper;

use app\services\AdminService;
use app\models\Project;
use app\models\project\DeleteProject;
use app\models\project\RecoverProject;


class ProjectController extends PublicController
{
    /**
     * 搜索项目
     * @return string
     */
    public function actionIndex()
    {
        $params = Yii::$app->request->queryParams;
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
        $params = Yii::$app->request->queryParams;
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
        $ret = ControllerHelper::AjaxPost('删除成功',function($post) use ($id) {
            AdminService::G()->deleteProject($id,$post);
        });
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
        $ret = ControllerHelper::AjaxPost('恢复成功',function($post) use ($id) {
            AdminService::G()->recoverProject($id,$post);
        });
        if($ret){
            return $ret;
        }
        $model = AdminService::G()->getProejctForRecycle($id);
        return $this->display('recover', ['project' => $model]);
    }

}
