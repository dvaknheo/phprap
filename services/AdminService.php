<?php

namespace app\services;

use Yii;
use yii\helpers\Html;
use app\models\LoginLog;
use app\models\Project;
use app\models\project\DeleteProject;
use app\models\project\RecoverProject;
use app\models\Account;
use app\models\account\PasswordForm;
use app\models\account\ProfileForm;
use app\models\Config;
use app\models\Module;
use app\models\Api;

class AdminService extends BaseService
{

    public function getDataForHome()
    {
        // 系统信息
        $system['installed_at'] = InstallLib::G()->getInstallTime();
        $system['app_os'] = PHP_OS;
        $system['app_version'] = Yii::$app->params['app_version'];
        $system['php_version'] = PHP_VERSION;
        $system['mysql_version'] = Yii::$app->db->createCommand('select version()')->queryScalar();

        $tongji = $this->getTongjiInfo();

        return ['system' => array2object($system), 'tongji' => $tongji];
    }

    public function getDataForLoginHistory($data)
    {
        $model = LoginLog::findModel()->search($data);
        $ret = [
            'model' => $model,
            'params' => $model->params,
        ];
        return $ret;
    }

    public function searchProject($params)
    {
        $params['status'] = Project::ACTIVE_STATUS;
        $model = Project::findModel()->search($params);
        $ret = [
            'project' => $model,
            'params' => $model->params,
        ];
        return $ret;
    }

    public function searchProjectRecycled($params)
    {
        $params['status'] = Project::DELETED_STATUS;
        $params['orderBy'] = 'updated_at desc';
        $model = Project::findModel()->search($params);
        $ret = [
            'project' => $model,
            'params' => $model->params,
        ];
        return $ret;
    }

    public function deleteProject($id, $post)
    {
        $model = DeleteProject::findModel(['encode_id' => $id]);
        $flag = $model->load($post);
        BaseServiceException::AssertOn($flag, '数据加载失败');
        $flag = $model->delete();
        BaseServiceException::AssertWithModel($flag, $model);
    }

    public function getProejctForDelete($id)
    {
        return DeleteProject::findModel(['encode_id' => $id]);
    }

    public function recoverProject($id, $post)
    {
        $model = RecoverProject::findModel(['encode_id' => $id]);
        $flag = $model->load($post);
        BaseServiceException::AssertOn($flag, '数据加载失败');
        $flag = $model->delete();
        BaseServiceException::AssertWithModel($flag, $model);
    }

    public function getProejctForRecycle($id)
    {
        return RecoverProject::findModel(['encode_id' => $id]);
    }

    ////
    public function searchUser($params)
    {
        $model = Account::findModel()->search($params);
        $ret = [
            'project' => $model,
            'params' => $model->params,
        ];
        return $ret;
    }

    public function setUserProfile($id, $post)
    {
        $this->setSuccessMessage('编辑成功');
        $model = ProfileForm::findModel($id);
        $flag = $model->load($post);
        BaseServiceException::AssertOn($flag, '加载数据失败', 'ProfileForm');
        $flag = $model->store();
        BaseServiceException::AssertWithModel($flag, $model);
    }

    public function getUserProfile($id)
    {
        return ProfileForm::findModel($id);
    }

    public function setUserPassword($id, $post)
    {
        $model = PasswordForm::findModel($id);
        $flag = $model->load($post);
        BaseServiceException::AssertOn($flag, '加载数据失败', 'PasswordForm');
        $flag = $model->store();
        BaseServiceException::AssertWithModel($flag, $model);
    }

    public function getUserPassword($id)
    {
        return PasswordForm::findModel($id);
    }

    //
    public function getSettingApp()
    {
        return Config::findOne(['type' => 'app']);
    }

    public function setSettingApp($post)
    {
        $config = Config::findOne(['type' => 'app']);
        $config->content = $this->form2json($post['Config'] ?? null);
        $flag = $config->save();
        BaseServiceException::AssertWithModel($flag, $model);
    }

    public function getSettingEmail()
    {
        return Config::findOne(['type' => 'email']);
    }

    public function setSettingEmail($post)
    {
        $config = Config::findOne(['type' => 'email']);
        $config->content = $this->form2json($post['Config'] ?? null);
        $flag = $config->save();
        BaseServiceException::AssertWithModel($flag, $model);
    }

    public function getSettingSafe()
    {
        return Config::findOne(['type' => 'safe']);
    }

    public function setSettingSafe($post)
    {
        $config = Config::findOne(['type' => 'safe']);

        $data = $post['Config'] ?? [];

        // 判断输入IP是否同时存在于白名单和黑名单
        $ip_white_list = explode("\r\n", trim($data['ip_white_list']));
        $ip_black_list = explode("\r\n", trim($data['ip_black_list']));

        $conflict_list = array_intersect($ip_white_list, $ip_black_list);

        $flag = array_filter($conflict_list);
        BaseServiceException::AssertOn(!$flag, '黑名单和白名单里不能出现相同的IP');

        // 判断邮箱后缀是否同时存在于白名单和黑名单
        $email_white_list = explode('\r\n', trim($data['email_white_list']));
        $email_black_list = explode('\r\n', trim($data['email_black_list']));

        $conflict_list = array_intersect($email_white_list, $email_black_list);

        $flag = array_filter($conflict_list);
        BaseServiceException::AssertOn(!$flag, '黑名单和白名单里不能出现相同的IP');

        $config->content = json_encode($data, JSON_UNESCAPED_UNICODE);
        $flag = $config->save();
        BaseServiceException::AssertWithModel($flag, $config);
    }

    /**
     * 表单过滤后转json
     * @param $table
     * @return false|string
     */
    protected function form2json($form)
    {
        if (!is_array($form) || !$form) {
            return;
        }
        $array = [];
        foreach ($form as $k => $v) {
            $array[$k] = trim(Html::encode($v));
        }

        return json_encode($array, JSON_UNESCAPED_UNICODE);
    }

    protected function getTongjiInfo()
    {
        $ret = new \stdClass();
        $ret->countTotalAccount = $this->getTotalAccount(null, 10)->count;
        $ret->countTodayAccount = $this->getTotalAccount(null, 10)->count;
        $ret->countTodayProject = $this->getTotalProject(10)->count;
        $ret->countTodayProject = $this->getTodayProject(10)->count;

        $ret->countTodayModule = $this->getTotalModule(10)->count;
        $ret->countTodayModule = $this->getTodayModule(10)->count;

        $ret->countTodayApi = $this->getTotalApi(10)->count;
        $ret->countTodayApi = $this->getTodayApi(10)->count;

        $ret->countTotalAccountEnabled = $this->getTotalAccount(10, 10)->count;
        $ret->countTotalAccountDisabled = $this->getTotalAccount(20, 10)->count;

        $ret->countTotalProjectEnabled = $this->getTotalProject(10)->count;
        $ret->countTotalProjectDisabled = $this->getTotalProject(30)->count;


        return $ret;
//*/
    }

    /**
     * 获取全部会员
     * @return Account|null
     */
    private function getTotalAccount($status = null, $type = null)
    {
        return Account::findModel()->search(['status' => $status, 'type' => $type]);
    }

    /**
     * 获取当天新增会员
     * @return Account|null
     */
    private function getTodayAccount($status = null, $type = null)
    {
        return Account::findModel()->search([
                    'type' => $type,
                    'status' => $status,
                    'start_date' => date('Y-m-d'),
                    'end_date' => date('Y-m-d'),
        ]);
    }

    /**
     * 获取全部项目
     * @param null $type
     * @return Project|null
     * @throws \Exception
     */
    private function getTotalProject($status = null, $type = null)
    {
        return Project::findModel()->search(['type' => $type, 'status' => $status]);
    }

    /**
     * 获取当天新增项目
     * @param null $type
     * @return Project|null
     * @throws \Exception
     */
    private function getTodayProject($status = null, $type = null)
    {
        return Project::findModel()->search([
                    'type' => $type,
                    'status' => $status,
                    'start_date' => date('Y-m-d'),
                    'end_date' => date('Y-m-d'),
        ]);
    }

    /**
     * 获取全部模块
     * @return mixed
     */
    private function getTotalModule($status = null)
    {
        return Module::findModel()->search(['status' => $status]);
    }

    /**
     * 获取当天新增模块
     * @return Project|null
     * @throws \Exception
     */
    private function getTodayModule($status = null)
    {
        return Module::findModel()->search([
                    'status' => $status,
                    'start_date' => date('Y-m-d'),
                    'end_date' => date('Y-m-d'),
        ]);
    }

    /**
     * 获取全部接口
     * @return mixed
     */
    private function getTotalApi($status = null)
    {
        return Api::findModel()->search(['status' => $status]);
    }

    /**
     * 获取当天新增接口
     * @return mixed
     */
    private function getTodayApi($status = null)
    {
        return Api::findModel()->search([
                    'status' => $status,
                    'start_date' => date('Y-m-d'),
                    'end_date' => date('Y-m-d'),
        ]);
    }

}
