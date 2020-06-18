<?php
namespace app\services;

use Yii;
use app\models\Field;
use app\models\Config;
use app\models\Module;
use app\models\Api;
use app\models\api\CreateApi;
use app\models\api\UpdateApi;
use app\models\api\DeleteApi;
use app\models\ProjectLog;
use app\models\projectLog\CreateLog;
use Curl\Curl;


class ApiService extends BaseService
{
    public function getDebugInfo($id)
    {
        $api = Api::findModel(['encode_id' => $id]);
        BaseServiceException::AssertOn($api->id,'抱歉，接口不存在或者已被删除');

        $project = $api->project;
        BaseServiceException::AssertOn(count($project->envs),'请先设置项目环境');
    }
    public function debug($id,$post)
    {
        $curl_api = $post['api'];
        $header_params = $post['header'];
        $request_params = $post['request'];
        
        $api = Api::findModel(['encode_id' => $id]);
        BaseServiceException::AssertOn($api->id,'抱歉，接口不存在或者已被删除');

        $project = $api->project;
        BaseServiceException::AssertOn(count($project->envs),'请先设置项目环境');
        
        $request_url = $curl_api['request_url'];
        $request_method = $curl_api['request_method'];
        $header_params = $this->getHeaderParams($header_params);
        $request_params = $this->getRequestParams($request_params);

        $curl = new Curl();

        $header_params && $curl->setHeaders($header_params);

        switch ($request_method) {
            case 'get':
                if (strpos($request_url, '?') !== false) {
                    $request_url .= '&';
                } else {
                    $request_url .= '?';
                }

                $request_url .= http_build_query($request_params);

                $curl->get($request_url);
                break;
            case 'post':
                $curl->post($request_url, $request_params);
                break;
            case 'put':
                $curl->put($request_url, $request_params);
                break;
            case 'delete':
                $curl->delete($request_url, $request_params);
                break;
        }

        if ($curl->error) {
            throw new BaseServiceException($curl->errorMessage,$curl->errorCode);
        }

        if ($api->response_format == 'json' and $api->response_auto_parse == 1) {
            //auto create
            /** @var Field $field */
//                $api->response_auto_parse = 0;
//                $api->save(false);
            $field = Field::findModel(['api_id' => $api->id]);
            if ($field) {
                if ($field->response_fields != "") {
                    $save = json_decode($field->response_fields, true);
                    $post = json_decode(Field::json2SaveJson($curl->rawResponse), true);
                    $res = Field::compareMergeResponseArray(
                        is_array($post) ? $post : [],
                        is_array($save) ? $save : []
                    );
                    $field->response_fields = json_encode($res);
                } else {
                    $field->response_fields = Field::json2SaveJson($curl->rawResponse);
                }
                $field->save();
            } else {
                $field = new Field();
                $field->encode_id = $id;
                $field->response_fields = Field::json2SaveJson($curl->rawResponse);
                $field->api_id = $api->id;
                $field->save(false);
            }
        }
        return ['status' => 'success', 'body' => $curl->rawResponse, 'info' => $curl->getInfo()];
    }
    /**
     * 获取header参数
     * @param $header
     * @return array
     */
    private function getHeaderParams($header)
    {
        if (!$header) {
            return [];
        }
        $params = [];
        foreach ($header as $k => $v) {
            foreach (array_filter($v) as $k1 => $v1) {
                $params[$header['name'][$k1]] = $header['value'][$k1];
            }
        }
        return $params;
    }

    /**
     * 获取请求参数
     * @param $request
     * @return array
     */
    private function getRequestParams($request)
    {
        if (!$request) {
            return [];
        }

        $params = [];
        if (isset($request['level']) and isset($request['name']) and isset($request['parent_id'])
            and isset($request['id']) and isset($request['example_value']) and isset($request['type'])) {
            foreach ($request['id'] as $index => $id) {
                switch ($request['type'][$index]) {
                    case 'object':
                        $params[$request['name'][$index]] = new \stdClass();
                        break;
                    case 'array':
                        $params[$request['name'][$index]] = [];
                        break;
                    case 'string':
                        $value = strval($request['example_value'][$index]);
                        $this->getValueFromRequest($request, $params, $index, $value);
                        break;
                    case 'integer':
                        $value = intval($request['example_value'][$index]);
                        $this->getValueFromRequest($request, $params, $index, $value);
                        break;
                    case 'float':
                        $value = floatval($request['example_value'][$index]);
                        $this->getValueFromRequest($request, $params, $index, $value);
                        break;
                    case 'boolean':
                        $value = boolval($request['example_value'][$index]);
                        $this->getValueFromRequest($request, $params, $index, $value);
                        break;

                }
            }
        }
        //var_dump($params);
//        foreach ($request as $k => $v) {
//            foreach (array_filter($v) as $k1 => $v1) {
//                $params[$request['name'][$k1]] = $request['example_value'][$k1];
//            }
//        }

        return $params;
    }

    private function getValueFromRequest(array $request, array &$params, $index, $value)
    {
        if ($request['parent_id'][$index] != '0') {

            foreach ($request['id'] as $pos => $parent_id) {
                if ($parent_id == $request['parent_id'][$index]) {

                    if (is_object($params[$request['name'][$pos]])) {

                        $params[$request['name'][$pos]]->{$request['name'][$index]} = $value;
                    } else {
                        //$request['name'][$index]
                        $params[$request['name'][$pos]][] = $value;
                    }
                }
            }
        } else {
            $params[$request['name'][$index]] = $value;
        }
    }
    public function getDataForCreate($module_id)
    {
        $module = Module::findModel(['encode_id' => $module_id]);
        $api = new CreateApi();
        return ['api' => $api, 'module' => $module];
    }
    public function create($post)
    {
        $model = new CreateApi();
        
        $flag = $model->load($post);
        BaseServiceException::AssertOn($flag,'数据加载失败');
        $flag = $model->store();
        BaseServiceException::AssertWithModel($flag,$model);
        return $model->encode_id;
    }
    public function getDataForUpdate($id)
    {
        $api = UpdateApi::findModel(['encode_id' => $id]);
        return ['api' => $api];
    }
    public function update($id,$post)
    {
        $model =  UpdateApi::findModel(['encode_id' => $id]);
        
        $flag = $model->load($post);
        BaseServiceException::AssertOn($flag,'数据加载失败');
        $flag = $model->store();
        BaseServiceException::AssertWithModel($flag,$model);
        
        return $model->encode_id;
    }
    public function getDataForDelete($id)
    {
        $api = DeleteApi::findModel(['encode_id' => $id]);
        return ['api' => $api];
    }
    public function delete($id,$post)
    {
        $api =  DeleteApi::findModel(['encode_id' => $id]);
        
        $flag = $model->load($post);
        BaseServiceException::AssertOn($flag,'数据加载失败');
        $flag = $model->delete();
        BaseServiceException::AssertWithModel($flag,$model);
        
        return $model->module->project->encode_id;
    }
    public function show($id,$tab,$params,$is_guest,$is_admin)
    {
        $api = Api::findModel(['encode_id' => $id]);

        if (!$api->id) {
            BaseServiceException::ThrowOn(true, '抱歉，接口不存在或者已被删除');
        }
        //TODO 放到参数里
        if (!$is_admin && $api->status !== $api::ACTIVE_STATUS) {
            BaseServiceException::ThrowOn(true, '抱歉，接口已被禁用或已被删除');
        }

        if ($api->project->isPrivate()) {
            if ($is_guest) {
                return ['__redirect'=>true];
            }
            if (!$api->project->hasAuth(['project' => 'look'])) {
                BaseServiceException::ThrowOn(true,'抱歉，您无权查看');
            }
        }
        
        $assign['api'] = $api;
        $assign['project'] = $api->project;
        
        switch ($tab) {
            case 'field':
                $assign['field'] = $api->field;
                break;
            case 'debug':
                if (!$api->project->hasAuth(['api' => 'debug'])) {
                    BaseServiceException::ThrowOn(true,'抱歉，您无权查看');
                }
                $assign['field'] = $api->field;
                break;
            case 'history':
                if (!$api->project->hasAuth(['api' => 'history'])) {
                    BaseServiceException::ThrowOn(true,'抱歉，您无权查看');
                }
                $params['object_name'] = 'api';
                $params['object_id'] = $api->id;
                $assign['history'] = ProjectLog::findModel()->search($params);
                break;
        }
        return $assign;
    }
    public function getApiToExport($id)
    {
        $api = Api::findModel(['encode_id' => $id]);
        if (!$api->project->hasAuth(['api' => 'export'])) {
            BaseServiceException::ThrowOn(true,'抱歉，您没有操作权限');
        }
        // 记录操作日志
        $log = new CreateLog();
        $log->project_id = $api->id;
        $log->object_name = 'api';
        $log->object_id = $api->id;
        $log->type = 'export';
        $log->content = '导出了 ' . '<code>' . $file_name . '</code>';

        if (!$log->store()) {
            BaseServiceException::ThrowOn(true,$log->getErrorMessage());
        }
        
        return $api;
    }
    public function cacheExportLockCheck($id,$account_id)
    {
        $cache = Yii::$app->cache;
        $config = Config::findOne(['type' => 'app']);
        
        $cache_key = 'api_' . $id . '_' . $account_id;
        $cache_interval = (int)$config->export_time;

        if ($cache_interval > 0 && $cache->get($cache_key) !== false) {
            $remain_time = $cache->get($cache_key) - time();
            if ($remain_time > 0 && $remain_time < $cache_interval) {
                return false;
            }
        }
        return true;
    }
    public function cacheExportLockSet($id,$account_id)
    {
        $cache = Yii::$app->cache;
        $config = Config::findOne(['type' => 'app']);
        
        $cache_key = 'api_' . $id . '_' . $account_id;
        $cache_interval = (int)$config->export_time;
        
        // 限制导出频率, 60秒一次
        $cache_interval > 0 && $cache->set($cache_key, time() + $cache_interval, $cache_interval);

    }
}