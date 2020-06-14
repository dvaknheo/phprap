<?php
namespace app\services;

use Yii;
use app\models\Tongji;
use app\models\LoginLog;
use app\models\Project;
use app\models\project\DeleteProject;
use app\models\project\RecoverProject;

class AdminService extends BaseService
{
    public function getDataForHome()
    {
            // 系统信息
        $system['installed_at']  = Project::findModel()->getInstallTime();
        $system['app_os']        = PHP_OS;
        $system['app_version']   = Yii::$app->params['app_version'];
        $system['php_version']   = PHP_VERSION;
        $system['mysql_version'] = Yii::$app->db->createCommand('select version()')->queryScalar();
        
        $tongji = new Tongji;
        
        return ['system' => array2object($system), 'tongji' => $tongji];
    }
    public function getDataForLoginHistory($data)
    {
        return LoginLog::findModel()->search($data);
    }
    public function searchProject($params)
    {
        $params['status'] = Project::ACTIVE_STATUS;
        $model = Project::findModel()->search($params);
        return $model;
    }
    public function searchProjectRecycled($params)
    {
        $params['status']  = Project::DELETED_STATUS;
        $params['orderBy'] = 'updated_at desc';
        $model = Project::findModel()->search($params);
        return $model;
    }
    public function deleteProject($id,$post)
    {
        $model = DeleteProject::findModel(['encode_id' => $id]);
        if(!$model->load($post)) {
            throw (new BaseServiceException('数据加载失败'.var_export($post,true)));
        }
        if(!$model->delete()) {
            throw (new BaseServiceException())->attachModel($model);
        }
    }
    public function getProejctForDelete($id)
    {
         return DeleteProject::findModel(['encode_id' => $id]);
    }
    public function recycleProject($id,$post)
    {
        $model = RecoverProject::findModel(['encode_id' => $id]);
        if(!$model->load($post)) {
            throw (new BaseServiceException('数据加载失败'));
        }
        if(!$model->delete()) {
            throw (new BaseServiceException())->attachModel($model);
        }
    }
    public function getProejctForRecycle($id)
    {
        return RecoverProject::findModel(['encode_id' => $id]);
    }
    ////

}