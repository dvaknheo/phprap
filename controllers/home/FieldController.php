<?php

namespace app\controllers\home;

use Yii;
use app\helpers\ControllerHelper;
use app\services\FileddService;

class FieldController extends PublicController
{
    /**
     * 添加字段
     * @param $id
     * @param string $method
     * @return array|string
     */
    public function actionCreate($api_id)
    {
        $params = Yii::$app->request->queryParams;
        $is_template=($params['from'] == 'template') ? true:false;
        
        $ret = ControllerHelper::AjaxPost('添加成功',function($post)use($api_id) {
            $id = FieldService::G()->create($api_id,$post);
            $callback = url('home/api/show', ['id' => $id, 'tab' => 'field']);
            ControllerHelper::AjaxPostExtData(['callback' => $callback]);
        });
        if($ret){
            return $ret;
        }
        $assign=FieldService::G()->getDataForCreate($api_id,$is_template);
        return $this->display('/home/field/create', $assign);
    }

    /**
     * 更新字段
     * @param $id
     * @param string $method
     * @return array|string
     */
    public function actionUpdate($id)
    {
        $ret = ControllerHelper::AjaxPost('编辑成功',function($post)use($api_id) {
            $id = FieldService::G()->update($api_id,$post);
            $callback = url('home/api/show', ['id' => $id, 'tab' => 'field']);
            ControllerHelper::AjaxPostExtData(['callback' => $callback]);
        });
        if($ret){
            return $ret;
        }
        FieldService::G()->getDataForUpdate($id);
        return $this->display('/home/field/update', $assign);
    }
}
