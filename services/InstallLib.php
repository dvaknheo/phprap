<?php
namespace app\services;

use Yii;
use Jenssegers\Agent\Agent;
use itbdw\Ip\IpLocation;

class InstallLib extends BaseService
{
    public function isInstalled()
    {
        return file_exists(Yii::getAlias("@runtime") . '/install/install.lock');
    }
    /**
     * 获取程序安装时间
     * @return mixed
     */
    public function getInstallTime()
    {
        $file = Yii::getAlias("@runtime") .'/install/install.lock';
        if(file_exists($file)){
            $install = file_get_contents($file);
            return json_decode($install)->installed_at;
        }
    }
}
