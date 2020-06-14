<?php
namespace app\controllers\admin;

use Yii;
use yii\helpers\Html;
use yii\web\Response;
use app\models\Config;
use app\helpers\ControllerHelper;
use app\services\AdminService;

class SettingController extends PublicController
{
    /**
     * 基础设置
     *
     * @return string
     */
    public function actionApp()
    {
        $ret = ControllerHelper::AjaxPost('保存成功',function($post){
            AdminService::G()->setSettingApp($post);
        });
        if($ret){
            return $ret;
        }
    	$config = AdminService::G()->getSettingApp();
        return $this->display('app', ['config' => $config]);
    }

    /**
     * 邮箱设置
     * @return array|string
     */
    public function actionEmail()
    {
        $ret = ControllerHelper::AjaxPost('保存成功',function($post){
           $config = AdminService::G()->setSettingEmail($post);
        });
        if($ret){
            return $ret;
        }
        $config = AdminService::G()->setSettingEmail();
        return $this->display('email', ['config' => $config]);
    }

    /**
     * 安全设置
     * @return array|string
     */
    public function actionSafe()
    {
        $ret = ControllerHelper::AjaxPost('保存成功',function($post){
            AdminService::G()->setSettingSafe($post);
        });
        if($ret){
            return $ret;
        }
        $config = AdminService::G()->getSettingSafe();
        return $this->display('safe', ['config' => $config]);
    }
}
