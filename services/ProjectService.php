<?php
namespace app\services;
use Yii;
use app\models\Config;
use app\models\Project;
use app\models\Template;
use app\models\Member;
use app\models\Field;
use app\models\ProjectLog;
use app\models\project\CreateProject;
use app\models\project\UpdateProject;
use app\models\project\QuitProject;
use app\models\project\TransferProject;
use app\models\project\DeleteProject;

class ProjectService extends BaseService
{
    /**
     * 搜索项目
     * @return string
     */
    public function search($params)
    {
        $params['status'] = Project::ACTIVE_STATUS;
        $params['type']   = Project::PUBLIC_TYPE;
        $model = Project::findModel()->search($params);
        $ret = [
            'project' => $model,
            'params' => $model->params,
        ];
        return $ret;
    }
    public function getDataForCreate()
    {
        return new CreateProject();
    }
    /**
     * 添加项目
     * @return string
     */
    public function create($post)
    {
        $model = new CreateProject();
        
        $flag = $model->load($post);
        BaseServiceException::AssertOn($flag,'加载数据失败');
        $flag = $model->store();
        BaseServiceException::AssertWithModel($flag,$model);
    }
    public function getDataForUpdate($id)
    {
        return UpdateProject::findModel(['encode_id' => $id]);
    }
    /**
     * 编辑项目
     * @param $id 项目ID
     * @return array|string
     */
    public function actionUpdate($id,$post)
    {

        $model = UpdateProject::findModel(['encode_id' => $id]);
//编辑成功
        $flag = $model->load($post);
        BaseServiceException::AssertOn($flag,'加载数据失败');
        $flag = $model->store();
        BaseServiceException::AssertWithModel($flag,$model);
    }

    /**
     * 项目详情
     * @param $id 项目ID
     * @param string $tab
     * @return string
     */
    public function show($id, $tab = 'home',$params,$is_guest,$is_admin)
    {
        $project = Project::findModel(['encode_id' => $id]);

        if(!$project->id){
            BaseServiceException::ThrowOn(true, '抱歉，项目不存在或者已被删除');
        }

        if(!$is_admin && $project->status !== $project::ACTIVE_STATUS){
            BaseServiceException::ThrowOn(true, '抱歉，项目已被禁用或已被删除');
        }

        if($project->isPrivate()) {
            if(Yii::$app->user->isGuest) {
                return ['__redirect'=>true];
                //return $this->redirect(['home/account/login','callback' => Url::current()]);
            }

            if(!$project->hasAuth(['project' => 'look'])) {
                BaseServiceException::ThrowOn(true, '抱歉，您无权查看');
            }
        }
        
        $assign['project'] = $project;

        
        switch ($tab) {
            case 'template':
                if(!$project->hasAuth(['template' => 'look'])) {
                    BaseServiceException::ThrowOn(true,'抱歉，您无权查看');
                }
                $assign['template'] = Template::findModel(['project_id' => $project->id]);
                $assign['field'] = new Field();
                break;
            case 'env':
                if(!$project->hasAuth(['env' => 'look'])) {
                    BaseServiceException::ThrowOn(true,'抱歉，您无权查看');
                }
                break;
            case 'member':
                if(!$project->hasAuth(['member' => 'look'])) {
                    BaseServiceException::ThrowOn(true,'抱歉，您无权查看');
                }
                $params['project_id'] = $project->id;
                $assign['member'] = Member::findModel()->search($params);
                break;
            case 'history':
                if(!$project->hasAuth(['project' => 'history'])) {
                    BaseServiceException::ThrowOn(true,'抱歉，您无权查看');
                }
                $params['project_id'] = $project->id;
                $params['object_name'] = $params['object_name']??'project,env,member,module';
                
                $assign['history'] = ProjectLog::findModel()->search($params);
                break;
        }
        return $assign;
    }

    /**
     * 项目成员
     * @param $id 项目ID
     * @param null $name 搜索词
     * @return array
     */
    public function getDataForMember($id, $name = null)
    {
        $project = Project::findModel(['encode_id' => $id]);

        $members = $project->members;

        $user    = [];

        foreach ($members as $k => $member){
            if(strpos($member->account->name, $name) !== false || strpos($member->account->email, $name) !== false){
                $user[$k]['id']   = $member->account->id;
                $user[$k]['name'] = $member->account->fullName;
            }
        }
        // 重建索引
        return array_values($user);
    }
    public function getDataForTransfer($id)
    {
        return TransferProject::findModel(['encode_id' => $id]);
    }
    /**
     * 转让项目
     * @param $id 项目ID
     * @return array|string|Response
     */
    public function transfer($id,$post)
    {
        //return ['callback' => url('home/project/select')];
        $model   = TransferProject::findModel(['encode_id' => $id]);
        
        $flag = $model->load($post);
        BaseServiceException::AssertOn($flag,'加载数据失败');
        $flag = $model->transfer();
        BaseServiceException::AssertWithModel($flag,$model);
    }

    /**
     * @param $id 项目ID
     * @param string $format 导出格式 html|json
     * @return string
     */
    public function getDataForExport($id, $format = 'html')
    {
        $project = Project::findModel(['encode_id' => $id]);

        if(!$project->hasAuth(['project' => 'export'])){
            BaseServiceException::ThrowOn(true,'抱歉，您没有操作权限');
        }

        $account = Yii::$app->user->identity;
        
        $cache   = Yii::$app->cache;

        $config = Config::findOne(['type' => 'app']);

        $cache_key      = 'project_' . $id . '_' . $account->id;
        $cache_interval = (int)$config->export_time;

//        if($cache_interval >0 && $cache->get($cache_key) !== false){
//            $remain_time = $cache->get($cache_key)  - time();
//            if($remain_time >0 && $remain_time < $cache_interval){
//                return $this->error("抱歉，导出太频繁，请{$remain_time}秒后再试!", 5);
//            }
//        }

        // 限制导出频率, 60秒一次
        $cache_interval >0 && Yii::$app->cache->set($cache_key, time() + $cache_interval, $cache_interval);

        $file_name = $project->title . '离线文档' . '.' . $format;

        // 记录操作日志
        $log = new \app\models\ProjectLog();
        $flag = $log->createProjectLog($project->id, 'project', $project->id, 'export', '导出了 ' . '<code>' . $file_name . '</code>');
        if(!$flag){
            BaseServiceException::ThrowOn(true,$log->getErrorMessage());
        }
        
        return $project;
    }
    public function getDataForDelete($id)
    {
        return DeleteProject::findModel(['encode_id' => $id]);
    }
    /**
     * 删除项目
     * @param $id 项目ID
     * @return array|string
     */
    public function delete($id,$post)
    {
        $model = DeleteProject::findModel(['encode_id' => $id]);
        
        $flag = $model->load($post);
        BaseServiceException::AssertOn($flag,'加载数据失败');
        $flag = $model->delete();
        BaseServiceException::AssertWithModel($flag,$model);
    }
    public function getDataForQuit($id,$user_id)
    {
        $model  = QuitProject::findModel(['encode_id' => $id]);
        $member = Member::findModel(['project_id' => $model->id, 'user_id' => $user_id]);
        return ['project' => $model, 'member' => $member];
    }

    /**
     * 退出项目
     * @param $id 项目ID
     * @return array|string
     */
    public function quit($id,$post)
    {
        $model  = QuitProject::findModel(['encode_id' => $id]);
        
        $flag = $model->load($post);
        BaseServiceException::AssertOn($flag,'加载数据失败');
        $flag = $model->quit();
        BaseServiceException::AssertWithModel($flag,$model);
    }
}
