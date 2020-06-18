<?php
namespace app\services;

use app\models\Project;
use app\models\env\CreateEnv;
use app\models\env\DeleteEnv;
use app\models\env\UpdateEnv;


class EnvService extends BaseService
{
    public function create($project_id,$post)
    {
        $project = Project::findModel(['encode_id' => $project_id]);
        $model   = new CreateEnv();
        $model->project_id = $project->id;
        
        $flag = $model->load($post);
        BaseServiceException::AssertOn($flag,'数据加载失败','CreateEnv');
        $flag = $model->store();
        BaseServiceException::AssertWithModel($flag,$model);
    }
    public function getDataForCreate($project_id)
    {
        $project = Project::findModel(['encode_id' => $project_id]);

        $model   = new CreateEnv();
        $model->project_id = $project->id;
        return $model->getNextEnv();
    }
    public function getDataForUpdate($id)
    {
        return UpdateEnv::findModel(['encode_id' => $id]);
    }
    public function getDataForDelete($id)
    {
        return DeleteEnv::findModel(['encode_id' => $id]);
    }
    public function update($id,$post)
    {
        $model   = UpdateEnv::findModel(['encode_id' => $id]);
        $flag = $model->load($post);
        BaseServiceException::AssertOn($flag,'数据加载失败','UpdateEnv');
        $flag = $model->store();
        BaseServiceException::AssertWithModel($flag,$model);
    }
    public function delete($id,$post)
    {
        $model   = DeleteEnv::findModel(['encode_id' => $id]);
        $flag = $model->load($post);
        BaseServiceException::AssertOn($flag,'数据加载失败','DeleteEnv');
        $flag = $model->delete();
        BaseServiceException::AssertWithModel($flag,$model);
    }
}