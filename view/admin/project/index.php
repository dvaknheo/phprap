<?php include_view(['name'=>'home/public/header','title'=>'项目管理'])?>

</head>

<body>

<div id="wrapper">

    <!-- Navigation -->
    <?php include_view(['name'=>'home/public/nav','sidebar'=>'admin/public/sidebar','active'=>'project'])?>
    <div id="page-wrapper">

        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">项目管理
                    <small>(<?=$project->count?>)</small>
                </h1>

                <div class="search">
                    <div class="row">
                        <form action="<?=url()?>" method="get" autocomplete="off">

                            <div class="col-sm-4">

                                <div class="form-group">
                                    <input name="title" type="text" class="form-control" placeholder="项目名称，支持模糊查询" value="<?=$params->title?>">
                                </div>
                            </div>

                            <div class="col-sm-4">

                                <div class="form-group">
                                    <input name="user[name]" type="text" class="form-control" placeholder="创建人昵称或邮箱，支持模糊查询" value="<?=$params->user->name?>">
                                </div>
                            </div>

                            <div class="col-sm-4">

                                <div class="form-group">
                                    <select class="form-control" name="type">
                                        <option disabled="" selected="" style="display:none;">项目类型</option>
                                        <option value="">不限</option>
                                        <?php foreach($project->typeLabels as $k => $v){?>
                                        <option value="<?=$k?>" <?php if($params->type == $k){?>selected<?php }?>><?=$v?></option>
                                        <?php }?>
                                    </select>
                                </div>

                            </div>


                            <div class="col-sm-12">

                                <div class="form-group">
                                    <button type="reset" class="btn btn-warning mr-1">重置</button>

                                    <button type="submit" class="btn btn-primary">搜索</button>
                                </div>
                            </div>


                        </form>

                    </div>
                </div>

            </div>
            <!-- /.col-lg-12 -->
        </div>
        <!-- /.row -->
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <?php include_view(['name'=>'admin/project/tab','active'=>'index'])?>
                    <!-- /.panel-heading -->
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th>项目名称</th>
                                    <th width="80px">项目类型</th>
                                    <th>创建人昵称/账号</th>
                                    <th width="60px">成员数</th>
                                    <th width="60px">模块数</th>
                                    <th width="60px">接口数</th>
                                    <th class="datetime">创建时间</th>
                                    <?php if($project->count){?>
                                    <th width="150px"></th>
                                    <?php }?>
                                </tr>
                                </thead>
                                <tbody>
                                <?php foreach($project->models as $model){?>

                                <tr <?php if($model->status != $model::ACTIVE_STATUS){?>class="danger"<?php }?>>
                                    <td ><?=$model->title?></td>
                                    <td ><?=$model->typeLabel?></td>

                                    <td ><?=$model->creater->fullName?></td>
                                    <td class="text-center"><a href="<?=url('admin/user/index', ['project_id' => $model->encode_id])?>" data-toggle="tooltip" title="" data-original-title="点击查看成员"><?=$model->getMembersCount()?></a></td>
                                    <td class="text-center"><?=$model->getModulesCount()?></td>
                                    <td class="text-center"><?=$model->getApisCount()?></td>

                                    <td ><?=$model->created_at?></td>
                                    <?php if($project->count){?>
                                    <td >
                                        <a type="button" class="btn btn-danger btn-xs hidden-xs mr-1" data-modal="#js_popModal" data-height="200" data-src="<?=url('admin/project/delete', ['id' => $model->encode_id])?>" data-toggle="tooltip" data-placement="bottom" data-title="删除项目">删除</a>
                                        <a class="btn btn-success btn-xs mr-1" target="_blank" data-toggle="tooltip" data-placement="bottom" data-title="查看项目" href="<?=url('home/project/show', ['id' => $model->encode_id])?>">查看</a>
                                        <a class="btn btn-info btn-xs" target="_blank" data-toggle="tooltip" data-placement="bottom" data-title="项目动态" href="<?=url('home/project/show', ['id' => $model->encode_id, 'tab' => 'history'])?>">动态</a>
                                    </td>
                                    <?php }?>
                                </tr>
                                <?php }?>

                                </tbody>
                            </table>
                        </div>
                        <?=$project->pages?>
                        <!-- /.table-responsive -->
                    </div>
                    <!-- /.panel-body -->
                </div>
                <!-- /.panel -->
            </div>

            <!-- /.col-lg-6 -->
        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

    <?php include_view(['name'=>'admin/public/footer'])?>
