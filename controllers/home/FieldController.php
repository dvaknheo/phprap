<?php
namespace app\controllers\home;

use app\helpers\ControllerHelper;
use app\services\FieldService;
use app\services\BaseServiceException;

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
        $params = ControllerHelper::REQUEST();
        $is_template=($params['from'] == 'template') ? true:false;
        
        if(ControllerHelper::IsAjax()) {
            try{
                $id = FieldService::G()->create($api_id,ControllerHelper::POST());
                $callback = url('home/api/show', ['id' => $id, 'tab' => 'field']);
                return ControllerHelper::AjaxPostExtData(['callback' => $callback,'message'=>'创建成功']);
            }catch(BaseServiceException $ex){
                return $ex->returnArray();
            }
        };
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
       if(ControllerHelper::IsAjax()) {
            try{
                $id = FieldService::G()->update($api_id, ControllerHelper::POST());
                $callback = url('home/api/show', ['id' => $id, 'tab' => 'field']);
                return ControllerHelper::AjaxPostExtData(['callback' => $callback,'message'=>'编辑成功']);
            }catch(BaseServiceException $ex){
                return $ex->returnArray();
            }
        };
        FieldService::G()->getDataForUpdate($id);
        return $this->display('/home/field/update', $assign);
    }
}
