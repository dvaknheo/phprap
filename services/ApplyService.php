<?php
namespace app\services;

use Yii;
use app\models\Project;
use app\models\Apply;
use app\models\apply\CreateApply;
use app\models\apply\UpdateApply;
use app\models\member\CreateMember;


class ApplyService extends BaseService
{
    public function search($params)
    {
        $params['check_status'] = Apply::CHECK_STATUS;
        $params['order_by']     = 'id desc';

        return Apply::findModel()->search($params);
    }
    public function getDataForCreate($project_id)
    {
        $model   = CreateApply::findModel();
        $project = Project::findModel(['encode_id' => $project_id]);
        return  ['apply' => $model, 'project' => $project];
    }
    public function create($project_id)
    {
        $model   = CreateApply::findModel();
        $model->project_id = $project_id;
        $flag = $model->store();
        BaseServiceException::AssertWithModel($flag,$model);
    }
    public function getDataForUpdate($id)
    {
        return UpdateApply::findModel($id);
    }
    public function pass($id,$post)
    {
        $model   = UpdateApply::findModel($id);
        
        $flag = $model->load($post);
        BaseServiceException::AssertOn($flag,'加载数据失败','UpdateApply');

        // 开启事务
        $transaction = Yii::$app->db->beginTransaction();
        
        $model->status = Apply::PASS_STATUS;
        
        $flag = $model->store();
        if(!$flag){
            $transaction->rollBack();
        }
        BaseServiceException::AssertWithModel($flag,$model);
        
        // 向项目成员表插入数据
        $member = CreateMember::findModel();
        $member->project_id   = $model->project_id;
        $member->user_id      = $model->user_id;
        $member->join_type    = $member::INITIATIVE_JOIN_TYPE;
        $member->project_rule = 'look';
        $member->env_rule     = 'look';
        $member->module_rule  = 'look';
        $member->api_rule     = 'look';
        $member->member_rule  = 'look';
        $member->template_rule = 'look';

        $flag = $member->store();
        if(!$flag){
            $transaction->rollBack();
        }
        BaseServiceException::AssertWithModel($flag,$member);
        // 事务提交
        $transaction->commit();
    }
    public function refuse($id,$post)
    {
        $model   = UpdateApply::findModel($id);

        $flag = $model->load($post);
        BaseServiceException::AssertOn($flag,'加载数据失败','UpdateApply');

        // 开启事务
        $transaction = Yii::$app->db->beginTransaction();
        
        $model->status = Apply::REFUSE_STATUS;
        
        $flag = $model->store();
        if(!$flag){
            $transaction->rollBack();
        }
        BaseServiceException::AssertWithModel($flag,$model);
        // 事务提交
        $transaction->commit();
    }
    public function getNotifyInfo()
    {
        $apply = Apply::findModel()->search(['check_status' => Apply::CHECK_STATUS]);

        return ['count' => $apply->count];
    }
}