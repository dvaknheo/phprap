<?php
namespace app\controllers\admin;

use yii\helpers\Url;
use app\services\AdminService;
use app\services\SessionService;
use app\services\BaseServiceException;

class HomeController extends PublicController
{
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }
    /**
     * 后台主页
     * @return string|\yii\web\Response
     * @throws \yii\db\Exception
     */
    public function actionIndex()
    {
        if(SessionService::G()->isGuest()){
            return $this->redirect(['home/account/login', 'callback' => Url::current()]);
        }
        $data=AdminService::G()->getDataForHome();
        return $this->display('index', $data);
    }
}
