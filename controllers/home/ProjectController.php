<?php
namespace app\controllers\home;

use Yii;
use yii\helpers\Url;
use app\helpers\ControllerHelper;
use app\services\ProjectService;
use app\services\SessionService;


class ProjectController extends PublicController
{
    public $checkLogin = false;

    /**
     * 选择项目
     * @return string
     */
    public function actionSelect()
    {
        if(SessionService::G()->isGuest()) {
            return $this->redirect(['home/account/login','callback' => Url::current()]);
        }

        return $this->display('select');
    }

    /**
     * 搜索项目
     * @return string
     */
    public function actionSearch()
    {
        if(SessionService::G()->isGuest()) {
            return $this->redirect(['home/account/login','callback' => Url::current()]);
        }

        $params = ControllerHelper::REQUEST();

        $data = ProjectService::G()->search($params);
        return $this->display('search', $data);
    }

    /**
     * 添加项目
     * @return string
     */
    public function actionCreate()
    {
        if(SessionService::G()->isGuest()) {
            return $this->redirect(['home/account/login']);
        }
        ControllerHelper::WrapExceptionOnce(ProjectService::G(),'添加成功');

        $ret = ControllerHelper::AjaxPost('添加成功',function($post) {
            ProjectService::G()->create($post);
        });
        if($ret){
            return $ret;
        }
        $model = ProjectService::G()->getDataForCreate();
        return $this->display('create', ['project' => $model]);
    }

    /**
     * 编辑项目
     * @param $id 项目ID
     * @return array|string
     */
    public function actionUpdate($id)
    {
        if(SessionService::G()->isGuest()) {
            return $this->redirect(['home/account/login']);
        }
        ControllerHelper::WrapExceptionOnce(ProjectService::G(),'添加成功');

        $ret = ControllerHelper::AjaxPost('编辑成功',function($post)use($id) {
            ProjectService::G()->update($id, ControllerHelper::POST());
        });
        if($ret){
            return $ret;
        }
        $model = ProjectService::G()->getDataForUpdate($id);
        return $this->display('update', ['project' => $model]);
    }

    /**
     * 项目详情
     * @param $id 项目ID
     * @param string $tab
     * @return string
     */
    public function actionShow($id, $tab = 'home')
    {
        $params = ControllerHelper::REQUEST();
        $is_guest = SessionService::G()->isGuest();
        $is_admin = Yii::$app->user->identity->isAdmin;
        
        try{
            $assign = ProjectService::G()->show($id,$tab,$params,$is_guest,$is_admin);
        }catch(BaseServiceException $ex){
            return $this->error($ex->getErrorMessage());
        }
        if(isset($assign['__redirect'])){
            return $this->redirect(['home/account/login', 'callback' => Url::current()]);
        }
        $view_map=[
            'home'      => '/home/project/home',
            'template'  => '/home/template/home',
            'env'       => '/home/env/index',
            'member'    => '/home/member/index',
            'history'   => '/home/history/project',
        ];
        $view = $view_map[$tab]??'/home/project/home';

        return $this->display($view, $assign);
    }

    /**
     * 项目成员
     * @param $id 项目ID
     * @param null $name 搜索词
     * @return array
     */
    public function actionMember($id, $name = null)
    {
        if(SessionService::G()->isGuest()) {
            return $this->redirect(['home/account/login']);
        }
        
        Yii::$app->response->format = Response::FORMAT_JSON;
        return ProjectService::G()->getDataForMember($id, $name);
    }

    /**
     * 转让项目
     * @param $id 项目ID
     * @return array|string|Response
     */
    public function actionTransfer($id)
    {
        if(SessionService::G()->isGuest()) {
            return $this->redirect(['home/account/login']);
        }

        $ret = ControllerHelper::AjaxPost('转让成功',function($post)use($id) {
            ProjectService::G()->transfer($id, ControllerHelper::POST());
            ControllerHelper::AjaxPostExtData(['callback' => url('home/project/select')]);
        });
        if($ret){
            return $ret;
        }
        $model   = ProjectService::G()->getDataForTransfer($id);
        return $this->display('transfer', ['project' => $model]);
    }

    /**
     * @param $id 项目ID
     * @param string $format 导出格式 html|json
     * @return string
     */
    public function actionExport($id, $format = 'html')
    {

        try{
            ProjectService::G()->getDataForExport($id,$format);
         }catch(BaseServiceException $ex){
            return $this->error($ex->getErrorMessage());
        }
        $project = Project::findModel(['encode_id' => $id]);
        $file_name = $project->title . '离线文档' . '.' . $format;

        header ("Content-Type: application/force-download");
        switch ($format) {
            case 'html':
                header ("Content-Disposition: attachment;filename=$file_name");
                return $this->display('export', ['project' => $project]);
            case 'json':
                header ("Content-Disposition: attachment;filename=$file_name");
                return $project->getJson();
        }

    }

    /**
     * 删除项目
     * @param $id 项目ID
     * @return array|string
     */
    public function actionDelete($id)
    {
        if(SessionService::G()->isGuest()) {
            return $this->redirect(['home/account/login']);
        }

        $ret = ControllerHelper::AjaxPost('删除成功',function($post)use($id) {
            ProjectService::G()->delete($id, ControllerHelper::POST());
            ControllerHelper::AjaxPostExtData(['callback' => url('home/project/select')]);
        });
        if($ret){
            return $ret;
        }
        $model   = ProjectService::G()->getDataForDelete($id);
        return $this->display('delete', ['project' => $model]);
    }

    /**
     * 退出项目
     * @param $id 项目ID
     * @return array|string
     */
    public function actionQuit($id)
    {
        if(SessionService::G()->isGuest()) {
            return $this->redirect(['home/account/login']);
        }
        $user_id = SessionService::G()->getCurrentUid();
        
        $ret = ControllerHelper::AjaxPost('退出成功',function($post)use($id) {
            ProjectService::G()->quit($id, ControllerHelper::POST());
            ControllerHelper::AjaxPostExtData(['callback' => url('home/project/select')]);
        });
        if($ret){
            return $ret;
        }
        $data  = ProjectService::G()->getDataForQuit($id,$user_id);
        return $this->display('quit', $data);
    }
}
