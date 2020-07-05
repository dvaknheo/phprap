<?php
namespace app\controllers\admin;

use Yii;
use yii\helpers\Url;
use yii\web\Controller;
use app\models\Apply;
use app\services\InstallService;

class PublicController extends Controller
{
    public $layout       = false;
    public $beforeAction = true;
    public $checkLogin   = true;

    public function beforeAction($action)
    {
        if($this->beforeAction){
            if(!InstallService::G()->isInstalled()){
                return $this->redirect(['home/install/step1'])->send();
            }

            if($this->checkLogin && Yii::$app->user->isGuest){
                return $this->redirect(['home/account/login'])->send();
            }

            if(!Yii::$app->user->identity->isAdmin){
                return $this->error('抱歉，您无权访问');
            }
        }

        return true;
    }

    /** 展示模板
     * @param $view
     * @param array $params
     * @return string
     */
    public function display($view, $params = [])
    {
        $account = Yii::$app->user->identity;
        $data['creater_id'] = $account->id;
        $data['check_status'] = Apply::CHECK_STATUS;
        $data['order_by'] = 'id desc';

        $notify = Apply::findModel()->search($data);

        $params['notify_count']  = $notify->count;
        $params['account'] = $account;

        $params['installed_at'] = InstallService::G()->getInstallTime();
        $my_view = $this->fetch_view_override($view);
        exit($this->do_view_override($my_view, $params));
    }
    protected function do_view_override($view,$__params)
    {
        if(!defined('PHPRAP_CONSTS')){
            define('PHPRAP_CONSTS',true);
            define('APP_VERSION',Yii::$app->params['app_version']);
            define('STATIC_URL',Yii::getAlias("@web") . '/static');
            define('STATIC_VERSION',Yii::$app->params['static_version']);
        }
    
        $__file=Yii::getAlias('@app').'/view/'.$view.'.php';
        unset($view);
        extract($__params);
        unset($__params);
        include $__file;
    }
    protected function fetch_view_override($view)
    {
        $path_module=Yii::$app->controller->module->getViewPath();
        $path_view=$this->getViewPath();
        $my_view=substr($path_view,strlen($path_module)+1).DIRECTORY_SEPARATOR . $view;
        $file=Yii::getAlias('@app').'/view/'.$my_view.'.php';
        return is_file($file)?$my_view:'';
    }
}
