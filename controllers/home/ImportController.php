<?php
namespace app\controllers\home;

use app\services\ImportService;

class ImportController extends PublicController
{
    /**
     * 导入项目
     * @param $id
     * @return string
     */
    public function actionProject($id)
    {
        $project = ImportService::G()->project($id);

        return $this->display('project', ['project' => $project]);
    }

    /**
     * 导入接口
     * @param $id
     * @return string
     */
    public function actionApi($id)
    {
        $api = ImportService::G()->api($id);

        return $this->display('api', ['api' => $api]);
    }

}
