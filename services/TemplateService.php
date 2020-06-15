<?php
namespace app\controllers\home;

use Yii;
use yii\helpers\Html;
use yii\web\Response;
use app\models\Project;
use app\models\Field;
use app\models\template\CreateTemplate;
use app\models\template\UpdateTemplate;

class TemplateService extends BaseService
{
    /**
     * 添加模块
     * @param $project_id 项目ID
     * @return array|string
     */
    public function create($project_id,$post)
    {
        $project = Project::findModel(['encode_id' => $project_id]);
        
        $model = new CreateTemplate();
        $model->project_id = $project->id;
        $model->header_fields   = $this->form2json($post['header']);
        $model->request_fields  = $this->form2json($post['request']);
        $model->response_fields = $this->form2json($post['response']);
            
        $flag = $model->store();
        BaseServiceException::AssertWithModel($flag,$model);
        
        return $project->encode_id;
    }

    /**
     * 更新模块
     * @param $id 模块ID
     * @return array|string
     */
    public function update($id,$post)
    {
        $model = UpdateModule::findModel(['encode_id' => $id]);
        
        $model->header_fields   = $this->form2json($post['header']);
        $model->request_fields  = $this->form2json($post['request']);
        $model->response_fields = $this->form2json($post['response']);
        
        $flag = $model->store();
        BaseServiceException::AssertWithModel($flag,$model);
        return $model->project->encode_id;
    }
    
    public function getDataForCreate($project_id)
    {
        $project = Project::findModel(['encode_id' => $project_id]);
        $field = new Field();
        $model = new CreateTemplate();
        
        return ['project' => $project, 'field' => $field, 'template' => $model];
    }
    public function getDataForUpdate($id)
    {
        $model   = UpdateTemplate::findModel(['encode_id' => $id]);
        $field   = new Field();
        
        return ['project' => $model->project, 'field' => $field, 'template' => $model];
    }

    
    /**
     * 表单过滤后转json
     * @param $table
     * @return false|string
     */
    private function form2json($table)
    {
        if(!is_array($table) || !$table){
            return;
        }
        $array = [];
        foreach ($table as $k => $v) {
            foreach ($v as $k1 => $v1) {
                $array[$k1][$k] = trim(Html::encode($v1));
            }
        }

        return json_encode($array, JSON_UNESCAPED_UNICODE);
    }
}
