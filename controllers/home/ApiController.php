<?php

namespace app\controllers\home;

use Yii;
use yii\helpers\Url;
use app\helpers\ControllerHelper;
use app\services\ApiService;

class ApiController extends PublicController
{
    public $checkLogin = false;

    /**
     * 在线调试
     * @param $id
     * @return array|string
     */
    public function actionDebug($id)
    {
        /** @var Api $api */
        $ret = ControllerHelper::AjaxPost('',function($post)use($id) {
            $data = ApiService::G()->debug($id, ControllerHelper::POST());
            ControllerHelper::AjaxPostExtData($data);
        });
        if($ret){
            return $ret;
        }
        try{
            ApiService::G()->getDebugInfo($id);
        }catch(BaseServiceException $ex){
            $this->error($this->getErrorMessage());
        }
    }

    /**
     * 添加接口
     * @param $module_id 模块ID
     * @return array|string
     */
    public function actionCreate($module_id)
    {
        $ret = ControllerHelper::AjaxPost('创建成功',function($post) {
            $encode_id = ApiService::G()->create($post);
            $callback = url('home/api/show', ['id' => $encode_id]);
            ControllerHelper::AjaxPostExtData(['callback' => $callback]);
        });
        if($ret){
            return $ret;
        }
        $data = ApiService::G()->getDataForCreate($module_id);

        return $this->display('create',$data);
    }

    /**
     * 更新接口
     * @param $id 接口ID
     * @return array|string
     */
    public function actionUpdate($id)
    {
        $ret = ControllerHelper::AjaxPost('编辑成功',function($post) use($id) {
            $encode_id = ApiService::G()->update($module_id, $post);
            $callback = url('home/api/show', ['id' => $encode_id]);
            ControllerHelper::AjaxPostExtData(['callback' => $callback]);
        });
        if($ret){
            return $ret;
        }
        $data = ApiService::G()->getDataForUpdate($id);


        return $this->display('update', $data);
    }

    /**
     * 删除接口
     * @param $id 接口ID
     * @return array|string
     */
    public function actionDelete($id)
    {
        $ret = ControllerHelper::AjaxPost('删除成功',function($post) use($id) {
            $encode_id = ApiService::G()->delete($id, $post);
            $callback = url('home/api/show', ['id' => $encode_id]);
            ControllerHelper::AjaxPostExtData(['callback' => $callback]);
        });
        if($ret){
            return $ret;
        }

    $data = ApiService::G()->getDataForDelete($id);
        return $this->display('delete', $data);
    }

    /**
     * 接口详情
     * @param $id 接口ID
     * @return string
     */
    public function actionShow($id, $tab = 'home')
    {
        $params = ControllerHelper::REQUEST();
        $is_guest = SessionService::G()->isGuest();
        $is_admin = Yii::$app->user->identity->isAdmin;
        try{
            $assign = ApiService::G()->show($id,$tab,$params,$is_guest,$is_admin);
        }catch(BaseServiceException $ex){
            return $this->error($ex->getErrorMessage());
        }
        if(isset($assign['__redirect'])){
            return $this->redirect(['home/account/login', 'callback' => Url::current()]);
        }
        $view_map=[
            'home'      => '/home/api/home',
            'field'     => '/home/field/home',
            'debug'     => '/home/api/debug',
            'history'   => '/home/history/api',
        ];
        $view = $view_map[$tab]??'/home/api/home';
        return $this->display($view, $assign);

    }

    /**
     * 导出接口文档
     * @param $id 接口ID
     * @return string
     */
    public function actionExport($id)
    {
        $account = Yii::$app->user->identity;
        $flag= ApiService::G()->cacheExportLockCheck($id,$account->id);
        if(!$flag){
            $this->error("抱歉，导出太频繁，请{\$remain_time}秒后再试!", 5);
        }
        
        try{
            $api= ApiService::G()->getApiToExport($id);
        }catch(BaseServiceException $ex){
            return $this->error($ex->getErrorMessage());
        }
        $file_name = "[{$api->module->title}]" . $api->title . '离线文档.html';
        
        header("Content-Type: application/force-download");
        header("Content-Disposition: attachment;filename=$file_name");

        // 限制导出频率, 60秒一次
        ApiService::G()->cacheExportLockSet($id,$account->id);
        return $this->display('export', ['api' => $api]);
    }
}
