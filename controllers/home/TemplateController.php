<?php
namespace app\controllers\home;

use Yii;
use app\helpers\ControllerHelper;
use app\services\TemplateService;


class TemplateController extends PublicController
{
    /**
     * 添加项目
     * @return string
     */
    public function actionCreate($project_id)
    {
        $ret = ControllerHelper::AjaxPost('添加成功',function($post)use($project_id) {
            $id = TemplateService::G()->create($project_id, ControllerHelper::POST());
            $callback = url('home/project/show', ['id' => $id, 'tab' => 'template']);
            ControllerHelper::AjaxPostExtData(['callback' => $callback]);
        });
        if($ret){
            return $ret;
        }
        $data = TemplateService::G()->getDataForCreate($project_id);
        return $this->display('create', $data);
    }

    /**
     * 更新模板
     * @param $id 模板ID
     * @return array|string
     */
    public function actionUpdate($id)
    {
        $ret = ControllerHelper::AjaxPost('编辑成功',function($post)use($id) {
            $id = TemplateService::G()->update($id, ControllerHelper::POST());
            $callback = url('home/project/show', ['id' => $id, 'tab' => 'template']);
            ControllerHelper::AjaxPostExtData(['callback' => $callback]);
        });
        if($ret){
            return $ret;
        }
        
        $data = TemplateService::G()->getDataForCreate($id);
        return $this->display('update', $data);
    }
}
