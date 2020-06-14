<?php
namespace app\controllers\admin;

use Yii;
use yii\helpers\Url;
use app\services\AdminService;

class HomeController extends PublicController
{
    /**
     * 后台主页
     * @return string|\yii\web\Response
     * @throws \yii\db\Exception
     */
    public function actionIndex()
    {
        if(Yii::$app->user->isGuest){
            return $this->redirect(['home/account/login', 'callback' => Url::current()]);
        }

        $data=AdminService::G()->getDataForHome();
        return $this->display('index', $data);
    }
}
