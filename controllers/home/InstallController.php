<?php
namespace app\controllers\home;

use app\services\InstallService;
use app\services\CacheService;
use app\helpers\ControllerHelper;

class InstallController extends PublicController
{
    //@override
    public function beforeAction($action)
    {
        if(InstallService::G()->isInstalled()){
            $app_version = InstallService::G()->getAppVersion();
            exit('PHPRAP V' . $app_version . ' 已安装过，请不要重复安装，如果需要重新安装，请先删除runtime/install/install.lock');
        }
        return true;
    }

    /**
     * 安装步骤一，环境检测
     * @return array|string
     */
    public function actionStep1()
    {
        if(ControllerHelper::IsAjax()){
            CacheService::G()->installStep(1);
            return $this->ajaxTo('home/install/step2');
        }

        $step1 = InstallService::G()->step1();
        return $this->display('/install/step1', ['step1' => $step1]);
    }

    /**
     * 安装步骤二，初始化数据库并将数据库信息写入配置文件
     * @return array|string|\yii\web\Response
     */
    public function actionStep2()
    {
        if(CacheService::G()->installStep() != 1){
            return $this->redirect(['home/install/step1']);
        }
        if(ControllerHelper::IsAjax()){
            try{
                $step2 = ControllerHelper::Post('Step2');
                InstallService::G()->step2($step2);
                CacheService::G()->installStep(2);
                return $this->ajaxTo('home/install/step3');
            }catch(\Exception $e){
                return $this->ajaxError($e);
            }

        }

        return $this->display('/install/step2');
    }

    /**
     * 安装步骤三，创建总管理员
     * @return string|\yii\web\Response
     */
    public function actionStep3()
    {
        if(CacheService::G()->installStep() != 2){
            return $this->redirect(['home/install/step2']);
        }

        if(ControllerHelper::IsAjax()){
            try {
                $step3 = ControllerHelper::Post('Step3');
                InstallService::G()->step3($step3);
                CacheService::G()->installStep(3);
                return $this->ajaxTo('home/install/step4');
            } catch (\Throwable $e) {
                return $this->ajaxError($e);
            }
            
        }

        return $this->display('/install/step3');
    }

    /**
     * 安装步骤四，显示安装过程
     * @return string|\yii\web\Response
     */
    public function actionStep4()
    {
        if(CacheService::G()->installStep() != 3){
            return $this->redirect(['home/install/step3']);
        }
        try {
            $tables = InstallService::G()->step4();
        } catch (\Throwable $e) {
            return $this->ajaxError($e);
        }
        CacheService::G()->installStep(4);

        return $this->display('/install/step4', ['tables' => $tables]);
    }
    /** 展示模板
     * @param $view
     * @param array $params
     * @return string
     */
    public function display($view, $params = [])
    {
        exit($this->render($view . '.html', $params));
    }
    private function ajaxTo($url)
    {
        return ['status' => 'success', 'callback' => url($url)];
    }
    private function ajaxError($e)
    {
        return ['status' => 'error', 'message' => $e->getMessage()];
    }

}
