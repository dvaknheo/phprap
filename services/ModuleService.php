<?php
namespace app\controllers\home;

use Yii;
use yii\web\Response;
use app\models\Project;
use app\models\module\CreateModule;
use app\models\module\UpdateModule;
use app\models\module\DeleteModule;

class ModuleService extends BaseService
{
    /**
     * 添加模块
     * @param $project_id 项目ID
     * @return array|string
     */
    public function create($project_id,$post)
    {
        $project = Project::findModel(['encode_id' => $project_id]);
        $model = new CreateModule();
        $model->project_id = $project->id;

        $flag = $model->load($post);
        BaseServiceException::AssertOn($flag,'加载数据失败');
        $flag = $model->store();
        BaseServiceException::AssertWithModel($flag,$model);
    }

    /**
     * 更新模块
     * @param $id 模块ID
     * @return array|string
     */
    public function update($id,$post)
    {
        $model = UpdateModule::findModel(['encode_id' => $id]);
        
        $flag = $model->load($post);
        BaseServiceException::AssertOn($flag,'加载数据失败');
        $flag = $model->store();
        BaseServiceException::AssertWithModel($flag,$model);
    }
    public function getDataForUpdate($id)
    {
        return UpdateModule::findModel(['encode_id' => $id]);
    }
    /**
     * 删除模块
     * @param $id 模块ID
     * @return array|string
     */
    public function actionDelete($id)
    {
        $model  = DeleteModule::findModel(['encode_id' => $id]);
        
        $flag = $model->load($post);
        BaseServiceException::AssertOn($flag,'数据加载失败');
        $flag = $model->delete();
        BaseServiceException::AssertWithModel($flag,$model);
    }
    public function getDataForDelete($id)
    {
        return DeleteModule::findModel(['encode_id' => $id]);
    }
}
