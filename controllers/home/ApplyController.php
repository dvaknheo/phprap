<?php
namespace app\controllers\home;

use Yii;
use app\helpers\ControllerHelper;
use app\services\ApplyService;

class ApplyController extends PublicController
{
    /**
     * 申请列表
     * @return string
     */
    public function actionIndex()
    {
        $params = Yii::$app->request->queryParams;
        $model = ApplyService::G()->search($params);

        return $this->display('index', ['apply' => $model]);
    }

    /**
     * 添加申请
     * @param $project_id 项目ID
     * @return array|string
     */
    public function actionCreate($project_id)
    {
        $ret = ControllerHelper::AjaxPost('申请成功，请耐心等待项目创建人审核',function($post)use($project_id) {
            ApplyService::G()->create($project_id);
        });
        if($ret){
            return $ret;
        }
        $data = ApplyService::G()->getDataForCreate($project_id);
        return $this->display('create', $data);
    }

    /**
     * @param $id 申请ID
     * @return array|string
     * @throws \yii\db\Exception
     */
    public function actionPass($id)
    {

        $ret = ControllerHelper::AjaxPost('操作成功',function($post)use($id) {
            ApplyService::G()->pass($id,$post);
        });
        if($ret){
            return $ret;
        }
        
        $model = ApplyService::G()->getDataForUpdate($id);
        return $this->display('check', ['apply' => $model]);
    }

    /**
     * 拒绝申请
     * @param $id 申请ID
     * @return array|string
     * @throws \yii\db\Exception
     */
    public function actionRefuse($id)
    {
        $ret = ControllerHelper::AjaxPost('操作成功',function($post)use($id) {
            ApplyService::G()->refuse($id,$post);
        });
        if($ret){
            return $ret;
        }
        
        $model = ApplyService::G()->getDataForUpdate($id);
        return $this->display('check', ['apply' => $model]);
    }

    /**
     * 获取申请数量
     * @return array
     * @throws \Exception
     */
    public function actionNotify()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        return ApplyService::G()->getNotifyInfo();
    }

}
