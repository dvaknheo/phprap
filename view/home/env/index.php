<?php include_view(['name'=>'home/public/header','title'=>'项目环境'])?>

</head>

<body>

<div id="wrapper">

    <!-- Navigation -->
    <?php include_view(['name'=>'home/public/nav','sidebar'=>'home/project/sidebar'])?>
    <div id="page-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <div class="page-header">
                    <h1>项目环境
                        <small>(<?=$project->getEnvsCount()?>)</small>

                    </h1>
                    <div class="opt-btn">
                        <?php if($project->hasAuth(['env' => 'create'])){?>
                        <a href="javascript:void(0);" class="btn hidden-xs btn-sm btn-success js_addEnvBtn" data-modal="#js_popModal" data-height="210" data-title='添加环境' data-src="<?=url('home/env/create', ['project_id' => $project->encode_id])?>"><i class="fa fa-fw fa-plus"></i>添加</a>
                        <?php }?>
                    </div>
                </div>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <!-- /.row -->
        <div class="row">

            <div class="col-lg-12">

                <div class="panel panel-default">

                    <?php include_view(['name'=>'home/project/tab','tab'=>'env'])?>

                    <div class="panel-body">
                        <div class="table-responsive ">
                            <table class="table">

                                <thead>
                                <tr>
                                    <th>环境名称</th>
                                    <th>环境根路径</th>
                                    <th>创建人昵称/账号</th>
                                    <th class="datetime">添加时间</th>
                                    <?php if($project->hasAuth(['env' => 'update,delete'])){?>
                                    <th class="hidden-xs" width="95px"></th>
                                    <?php }?>
                                </tr>
                                </thead>
                                <tbody>
                                <?php foreach($project->envs as $env){?>
                                <tr>
                                    <td><?=$env->title?>(<?=$env->name?>)</td>
                                    <td><code><?=$env->base_url?></code></td>
                                    <td><?=$env->creater->fullName?></td>
                                    <td><?=$env->created_at?></td>
                                    <td class="hidden-xs">

                                        <?php if($project->hasAuth(['env' => 'update'])){?>
                                        <a class="btn btn-success btn-xs mr-1" data-toggle="tooltip" data-placement="top" data-title="编辑环境" data-modal="#js_popModal" data-height="210" data-src="<?=url('home/env/update', ['id' => $env->encode_id])?>">编辑</a>
                                        <?php }?>

                                        <?php if($project->hasAuth(['env' => 'delete'])){?>
                                        <a class="btn btn-danger btn-xs" data-toggle="tooltip" data-placement="top" data-title="删除环境" data-modal="#js_popModal" data-height="190" data-src="<?=url('home/env/delete', ['id' => $env->encode_id])?>">删除</a>
                                        <?php }?>
                                    </td>
                                </tr>
                                <?php }?>

                                </tbody>
                            </table>

                        </div>
                    </div>
                    <!-- /.panel-body -->
                </div>
                <!-- /.panel -->
            </div>
            <!-- /.col-lg-12 -->
        </div>

    </div>
    <!-- /#page-wrapper -->

</div>
<!-- /#wrapper -->
<?php include_view(['name'=>'home/public/copyright'])?>

<?php include_view(['name'=>'home/public/footer'])?>