<?php
namespace app\services;

use Yii;
use yii\helpers\Html;

use app\models\Tongji;
use app\models\LoginLog;
use app\models\Project;
use app\models\project\DeleteProject;
use app\models\project\RecoverProject;

use app\models\Account;
use app\models\account\PasswordForm;
use app\models\account\ProfileForm;
use app\models\Config;

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
        $flag = $model->load($post);
        BaseServiceException::AssertOn($flag,'数据加载失败');
        $flag = $model->delete();
        BaseServiceException::AssertWithModel($flag,$model);
    }
    public function getProejctForDelete($id)
    {
         return DeleteProject::findModel(['encode_id' => $id]);
    }
    public function recoverProject($id,$post)
    {
        $model = RecoverProject::findModel(['encode_id' => $id]);
        $flag = $model->load($post);
        BaseServiceException::AssertOn($flag,'数据加载失败');
        $flag = $model->delete();
        BaseServiceException::AssertWithModel($flag,$model);
    }
    public function getProejctForRecycle($id)
    {
        return RecoverProject::findModel(['encode_id' => $id]);
    }
    ////
    public function searchUser($params)
    {
        return Account::findModel()->search($params);
    }
    public function setUserProfile($id,$post)
    {
        $this->setSuccessMessage('编辑成功');
        $model = ProfileForm::findModel($id);
        $flag = $model->load($post);
        BaseServiceException::AssertOn($flag,'加载数据失败','ProfileForm');
        $flag = $model->store();
        BaseServiceException::AssertWithModel($flag,$model);
    }
    public function getUserProfile($id)
    {
        return ProfileForm::findModel($id);
    }
    public function setUserPassword($id,$post)
    {
        $model = PasswordForm::findModel($id);
        $flag = $model->load($post);
        BaseServiceException::AssertOn($flag,'加载数据失败','PasswordForm');
        $flag =$model->store();
        BaseServiceException::AssertWithModel($flag,$model);
    }
    public function getUserPassword($id)
    {
        return PasswordForm::findModel($id);
    }
    //
    public function getSettingApp()
    {
        return  Config::findOne(['type' => 'app']);
    }
    public function setSettingApp($post)
    {
        $config   = Config::findOne(['type' => 'app']);
        $config->content  = $this->form2json($post['Config']??null);
        $flag = $config->save();
        BaseServiceException::AssertWithModel($flag,$model);
    }
    public function getSettingEmail()
    {
        return  Config::findOne(['type' => 'email']);
    }
    public function setSettingEmail($post)
    {
        $config   = Config::findOne(['type' => 'email']);
        $config->content  = $this->form2json($post['Config']??null);
        $flag = $config->save();
        BaseServiceException::AssertWithModel($flag,$model);
    }
    public function getSettingSafe()
    {
        return  Config::findOne(['type' => 'safe']);
    }
    public function setSettingSafe($post)
    {
        $config   = Config::findOne(['type' => 'safe']);
        
        $data = $post['Config']??[];

        // 判断输入IP是否同时存在于白名单和黑名单
        $ip_white_list = explode("\r\n", trim($data['ip_white_list']));
        $ip_black_list = explode("\r\n", trim($data['ip_black_list']));

        $conflict_list = array_intersect($ip_white_list, $ip_black_list);

        $flag = array_filter($conflict_list);
        BaseServiceException::AssertOn(!$flag,'黑名单和白名单里不能出现相同的IP');
        
        // 判断邮箱后缀是否同时存在于白名单和黑名单
        $email_white_list = explode('\r\n', trim($data['email_white_list']));
        $email_black_list = explode('\r\n', trim($data['email_black_list']));

        $conflict_list = array_intersect($email_white_list, $email_black_list);

        $flag = array_filter($conflict_list);
        BaseServiceException::AssertOn(!$flag,'黑名单和白名单里不能出现相同的IP');
        
        $config->content  =  json_encode($data, JSON_UNESCAPED_UNICODE);
        $flag = $config->save();
        BaseServiceException::AssertWithModel($flag,$config);
    }


    /**
     * 表单过滤后转json
     * @param $table
     * @return false|string
     */
    protected function form2json($form)
    {
        if(!is_array($form) || !$form){
            return;
        }
        $array = [];
        foreach ($form as $k => $v) {
            $array[$k] = trim(Html::encode($v));
        }

        return json_encode($array, JSON_UNESCAPED_UNICODE);
    }
}




























