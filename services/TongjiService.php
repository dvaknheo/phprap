<?php
namespace app\services;

use Yii;

class TongjiService extends Service
{
    public function getTongjiInfo()
    {
/*
                                        <div>用户</div>
                            </div>
                            <div class="col-xs-8">
                                <div class="huge"><?=$tongji->getTotalAccount(null, 10)->count?></div>
                                <div>今日新增 <?=$tongji->getTodayAccount(null, 10)->count?></div>
                                <div>项目</div>
                            </div>
                            <div class="col-xs-8">
                                <div class="huge"><?=$tongji->getTotalProject(10)->count?></div>
                                <div>今日新增 <?=$tongji->getTodayProject(10)->count?></div>

                                <div>模块</div>
                            </div>
                            <div class="col-xs-8">
                                <div class="huge"><?=$tongji->getTotalModule(10)->count?></div>
                                <div>今日新增 <?=$tongji->getTodayModule(10)->count?></div>

                                <div>接口</div>
                            </div>
                            <div class="col-xs-8">
                                <div class="huge"><?=$tongji->getTotalApi(10)->count?></div>
                                <div>今日新增 <?=$tongji->getTodayApi(10)->count?></div>
                            </div>

                        {value:<?=$tongji->getTotalAccount(10, 10)->count?>, name:'有效用户'},
                        {value:<?=$tongji->getTotalAccount(20, 10)->count?>, name:'禁用用户'},

                        {value:<?=$tongji->getTotalProject(10)->count?>, name:'有效项目'},
                        {value:<?=$tongji->getTotalProject(30)->count?>, name:'删除项目'},
                        
//*/
    }
    /**
     * 获取全部会员
     * @return Account|null
     */
    public function getTotalAccount($status = null, $type = null)
    {
        return Account::findModel()->search(['status' => $status, 'type' => $type]);
    }

    /**
     * 获取当天新增会员
     * @return Account|null
     */
    public function getTodayAccount($status = null, $type = null)
    {
        return Account::findModel()->search([
            'type'       => $type,
            'status'     => $status,
            'start_date' => date('Y-m-d'),
            'end_date'   => date('Y-m-d'),
        ]);
    }

    /**
     * 获取全部项目
     * @param null $type
     * @return Project|null
     * @throws \Exception
     */
    public function getTotalProject($status = null, $type = null)
    {
        return Project::findModel()->search(['type' => $type, 'status' => $status]);
    }

    /**
     * 获取当天新增项目
     * @param null $type
     * @return Project|null
     * @throws \Exception
     */
    public function getTodayProject($status = null, $type = null)
    {
        return Project::findModel()->search([
            'type'       => $type,
            'status'     => $status,
            'start_date' => date('Y-m-d'),
            'end_date'   => date('Y-m-d'),
        ]);
    }

    /**
     * 获取全部模块
     * @return mixed
     */
    public function getTotalModule($status = null)
    {
        return Module::findModel()->search(['status' => $status]);
    }

    /**
     * 获取当天新增模块
     * @return Project|null
     * @throws \Exception
     */
    public function getTodayModule($status = null)
    {
        return Module::findModel()->search([
            'status'     => $status,
            'start_date' => date('Y-m-d'),
            'end_date'   => date('Y-m-d'),
        ]);
    }

    /**
     * 获取全部接口
     * @return mixed
     */
    public function getTotalApi($status = null)
    {
        return Api::findModel()->search(['status' => $status]);
    }

    /**
     * 获取当天新增接口
     * @return mixed
     */
    public function getTodayApi($status = null)
    {
        return Api::findModel()->search([
            'status'     => $status,
            'start_date' => date('Y-m-d'),
            'end_date'   => date('Y-m-d'),
        ]);
    }

}
