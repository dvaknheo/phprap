<?php
namespace app\services;

use Yii;
use Jenssegers\Agent\Agent;
use itbdw\Ip\IpLocation;

class CommonLib extends BaseService
{
    /**
     * 获取当前格式化时间
     * @param string $format
     * @return false|string
     */
    public function getNowTime($format = '')
    {
        $format = $format ? : 'Y-m-d H:i:s';
        return date($format);
    }

    /**
     * 获取友好的时间，如5分钟前
     * @return string
     */
    public function getFriendTime($time = null)
    {
        $time = $time ? strtotime($time) : time();
        return Yii::$app->formatter->asRelativeTime($time);
    }



    /**
     * 获取客户端IP
     * @return mixed|string|null
     */
    public function getUserIp()
    {
        return Yii::$app->request->userIP;
    }

    /**
     * 获取ip地理位置
     * @param null $ip
     * @return string
     */
    public function getLocation($ip = null)
    {
        $ip = $ip ? : $this->getUserIp();

        $location = IpLocation::getLocation($ip);

        $country  = $location['country'];
        $province = $location['province'];
        $city     = $location['city'] ? : $province;

        return $country . ' ' . $province . ' ' . $city;
    }

    /**
     * 获取访问者的操作系统
     * @return string
     */
    public function getOs()
    {
        $agent = new Agent();

        $platform = $agent->platform();
        $version  = $agent->version($platform);

        return $platform . '(' . $version . ')';
    }

    /**
     * 获取访问者浏览器
     * @return string
     */
    public function getBrowser()
    {
        $agent = new Agent();

        $browser = $agent->browser();
        $version = $agent->version($browser);

        return $browser . '(' . $version . ')';
    }

}
