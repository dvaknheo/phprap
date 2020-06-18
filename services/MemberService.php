<?php
namespace app\services;

use app\models\Member;
use app\models\Project;
use app\models\member\CreateMember;
use app\models\member\UpdateMember;
use app\models\member\RemoveMember;

class MemberService extends BaseService
{
    public function getDataForCreate($project_id)
    {
        $project = Project::findModel(['encode_id' => $project_id]);
        $model   = new CreateMember();
        return ['project' => $project, 'member' => $model];
    }
    /**
     * 添加成员
     * @param $project_id 项目ID
     * @return array|string
     */
    public function create($project_id,$post)
    {
        $project = Project::findModel(['encode_id' => $project_id]);
        $model   = new CreateMember();
        $model->project_id = $project->id;
        $model->join_type  = Member::PASSIVE_JOIN_TYPE;

        $flag = $model->load($post);
        BaseServiceException::AssertOn($flag,'加载数据失败');
        $flag = $model->store();
        BaseServiceException::AssertWithModel($flag,$model);
    }
    public function getDataForUpdate($id)
    {
        return UpdateMember::findModel(['encode_id' => $id]);
    }
    /**
     * 编辑成员
     * @param $id 成员ID
     * @return array|string
     */
    public function update($id,$post)
    {
        $model   = UpdateMember::findModel(['encode_id' => $id]);

        $flag = $model->load($post);
        BaseServiceException::AssertOn($flag,'加载数据失败');
        $flag = $model->store();
        BaseServiceException::AssertWithModel($flag,$model);
    }

    /**
     * 选择成员
     * @param $project_id 项目ID
     * @param $name 搜索词
     * @return array
     */
    public function getDataForSelect($project_id, $name)
    {
        $project = Project::findModel(['encode_id' => $project_id]);
        $notMembers = $project->getNotMembers(['name' => $name]);

        $user = [];
        foreach ($notMembers as $k => $member){
            $user[$k]['id']   = $member->id;
            $user[$k]['name'] = $member->fullName;
        }

        return $user;
    }

    public function getDataForRemove($id)
    {
        return RemoveMember::findModel(['encode_id' => $id]);
    }
    /**
     * 移除成员
     * @param $id 成员ID
     * @return array
     */
    public function remove($id,$post)
    {

        $model = RemoveMember::findModel(['encode_id' => $id]);

        $flag = $model->load($post);
        BaseServiceException::AssertOn($flag,'加载数据失败');
        $flag = $model->remove();
        BaseServiceException::AssertWithModel($flag,$model);
    }

    /**
     * 成员详情
     * @param $id 成员ID
     * @return string
     */
    public function getDataForShow($id)
    {
        return Member::findModel(['encode_id' => $id]);
    }
}
