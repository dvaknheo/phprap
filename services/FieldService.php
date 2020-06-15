<?php
namespace app\services;

use app\models\Field;
use Yii;
use yii\web\Response;
use app\models\Api;
use app\models\field\CreateField;
use app\models\field\UpdateField;


class FileddService
{
    public function create($api_id,$post)
    {
        $api = Api::findModel(['encode_id' => $api_id]);
        $model = CreateField::findModel();
        $model->api_id = $api->id;
        $model->header_fields = Field::form2json($post['header']);
        $model->request_fields = Field::form2json($post['request']);
        $model->response_fields = Field::form2json($post['response']);
        $flag = $model->store();
        BaseServiceException::AssertWithModel($flag,$model);
        return $api->encode_id;
    }
    public function getDataForCreate($api_id,$is_template)
    {
        $api = Api::findModel(['encode_id' => $api_id]);
        $model = CreateField::findModel();

        $assign['project'] = $api->project;
        $assign['api'] = $api;
        $assign['field'] = $model;

        if ($is_template) {
            $assign['template'] = $api->project->template;
        }
        return $assign;
    }
    public function getDataForUpdate($id)
    {
        $model = UpdateField::findModel(['encode_id' => $id]);
        $assign['project'] = $model->api->project;
        $assign['api'] = $model->api;
        $assign['field'] = $model;
        return $assign;
    }

    public function update($id,$post)
    {
        $model = UpdateField::findModel(['encode_id' => $id]);

        $fieldsType = $post['fields_type'];
        if ($fieldsType == "json") {
            $model->request_fields = UpdateField::json2SaveJson($post['request']);
        } else {
            $model->request_fields = UpdateField::form2json($post['request']);
        }
        $model->header_fields = UpdateField::form2json($pos['header');
        $model->response_fields = UpdateField::form2json($post['response']);

        $flag = $model->store();
        BaseServiceException::AssertWithModel($flag,$model);
        return $model->api->encode_id;
    }

}