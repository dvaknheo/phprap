<?php
namespace app\controllers\home;

use Yii;
use yii\helpers\Html;
use yii\web\Response;
use app\models\Project;
use app\models\Field;
use app\models\template\CreateTemplate;
use app\models\template\UpdateTemplate;

class TemplateController extends PublicController
{
    /**
     * 添加项目
     * @return string
     */
    public function actionCreate($project_id)
    {
        $request = Yii::$app->request;

        $project = Project::findModel(['encode_id' => $project_id]);
        $field = new Field();

        $model = new CreateTemplate();

        ControllerHelper::AjaxPost('添加成功',function()use($project_id){
            $encode_id="???";
            TemplateService::G()->create($project_id,$request->post('header'),$request->post('request'),$request->post('response'));
            $callback = url('home/project/show', ['id' => $encode_id, 'tab' => 'template']);
            ControllerHelper::AjaxPostExtData(['callback' => $callback];

        });

        return $this->display('create', ['project' => $project, 'field' => $field, 'template' => $model]);
    }

    /**
     * 更新模板
     * @param $id 模板ID
     * @return array|string
     */
    public function actionUpdate($id)
    {
        $request = Yii::$app->request;

        $model   = UpdateTemplate::findModel(['encode_id' => $id]);
        $field   = new Field();

        ControllerHelper::AjaxPost('添加成功',function()use($id){
            TemplateService::G()->update($project_id,$request->post('header'),$request->post('request'),$request->post('response'));
            $callback = url('home/project/show', ['id' => $encode_id, 'tab' => 'template']);
            ControllerHelper::AjaxPostExtData(['callback' => $callback];

        });

        return $this->display('update', ['project' => $model->project, 'field' => $field, 'template' => $model]);

    }
}
