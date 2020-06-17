<?php
namespace app\services;

use app\models\Project;
use app\models\Api;

class ImportService extends BaseService
{
    public function project($id)
    {
        return Project::findModel(['encode_id' => $id]);
    }
    public function api($id)
    {
        return Api::findModel(['encode_id' => $id]);
    }

}