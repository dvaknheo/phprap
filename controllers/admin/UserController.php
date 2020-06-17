<?php
namespace app\controllers\admin;

use Yii;
use yii\web\Response;
use app\models\Account;
use app\models\account\PasswordForm;
use app\models\account\ProfileForm;

class UserController extends PublicController
{
    /**
     * 成员列表
     * @return string
     */
    public function actionIndex()
    {
        $params = Yii::$app->request->queryParams;
        $model = AdminService::G()->searchUser($params);

        return $this->display('index', ['user' => $model]);
    }

    /**
     * 编辑账号
     * @return string
     */
    public function actionProfile($id)
    {
        $ret = ControllerHelper::AjaxPost('编辑成功',function($post)use($id){
            AdminService::G()->setUserProfile($id,$post);
        });
        if($ret){
            return $ret;
        }
        $model = AdminService::G()->getUserProfile($id);
        return $this->display('profile', ['user' => $model]);
    }

    /**
     * 修改密码
     * @return array|string
     */
    public function actionPassword($id)
    {
        $ret = ControllerHelper::AjaxPost('保存成功',function($post)use($id){
            AdminService::G()->setUserPassword($id,$post);
        });
        if($ret){
            return $ret;
        }
        $model = AdminService::G()->setUserPassword($id);
        return $this->display('password', ['user' => $model]);
    }

}
