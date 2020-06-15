<?php
namespace app\controllers\home;

use Yii;
use app\helpers\ControllerHelper;
use app\services\MemberService;

class MemberController extends PublicController
{
    /**
     * 添加成员
     * @param $project_id 项目ID
     * @return array|string
     */
    public function actionCreate($project_id)
    {
        //
        $ret = ControllerHelper::AjaxPost('添加成功',function($post)use($project_id) {
            MemberService::G()->create($project_id,$post);
        });
        if($ret){
            return $ret;
        }
        $data = MemberService::G()->getDataForCreate($project_id);
        return $this->display('create', $data);
    }

    /**
     * 编辑成员
     * @param $id 成员ID
     * @return array|string
     */
    public function actionUpdate($id)
    {
        $ret = ControllerHelper::AjaxPost('编辑成功',function($post)use($id) {
            MemberService::G()->update($id,$post);
        });
        if($ret){
            return $ret;
        }
        $model = MemberService::G()->getDataForUpdate($id);
        return $this->display('update', ['member' => $model]);
    }

    /**
     * 选择成员
     * @param $project_id 项目ID
     * @param $name 搜索词
     * @return array
     */
    public function actionSelect($project_id, $name)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        return MemberService::G()->getDataForSelect($project_id, $name);
    }

    /**
     * 移除成员
     * @param $id 成员ID
     * @return array
     */
    public function actionRemove($id)
    {
        $ret = ControllerHelper::AjaxPost('移出成功',function($post)use($id) {
            MemberService::G()->remove($id,$post);
        });
        if($ret){
            return $ret;
        }
        $model = MemberService::G()->getDataForRemove($id);
        return $this->display('remove', ['member' => $model]);
    }

    /**
     * 成员详情
     * @param $id 成员ID
     * @return string
     */
    public function actionShow($id)
    {
        $member = MemberService::G()->getDataForShow($id);

        return $this->display('show', ['member' => $member]);
    }

}
