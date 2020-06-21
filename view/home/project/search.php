<?php include_view(['name'=>'home/public/header','title'=>'搜索项目'])?>

</head>

<body>

<div id="wrapper">

    <!-- Navigation -->
    <?php include_view(['name'=>'home/public/nav','sidebar'=>'home/account/sidebar','active'=>'search'])?>
    <div id="page-wrapper">

        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">
                    搜索项目<small>(<?=$project->count?>)</small>
                </h1>
                <div class="alert alert-dismissable alert-warning">
                    <i class="fa fa-fw fa-info-circle"></i>&nbsp;
                    只有公开项目才能被搜索到，私有项目无法被搜索到
                </div>
                <div class="search">
                    <div class="row">
                        <form action="" method="get" autocomplete="off">

                            <div class="col-sm-4">

                                <div class="form-group">
                                    <input name="title" type="text" class="form-control" placeholder="项目名称，支持模糊查询" value="<?=$project->params->title?>">
                                </div>
                            </div>

                            <div class="col-sm-4">

                                <div class="form-group">
                                    <input name="user[name]" type="text" class="form-control" placeholder="创建人昵称或邮箱，支持模糊查询" value="<?=$project->params->user->name?>">
                                </div>
                            </div>

                            <div class="col-sm-4">

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

                    <!-- /.panel-heading -->
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th>项目名称</th>
                                    <th>我的角色</th>
                                    <th>创建人昵称/账号</th>
                                    <th width="60px">成员数</th>
                                    <th class="datetime">创建时间</th>
                                    <th class="datetime">更新时间</th>
                                    <?php if($project->count){?>
                                    <th width="95px"></th>
                                    <?php }?>
                                </tr>
                                </thead>
                                <tbody>
                                <?php foreach($project->models as $model){?>
                                <tr>
                                    <td >
                                        <?=$model->title?>
                                    </td>
                                    <td >
                                        <?=$model->role?>
                                    </td>
                                    <td ><?=$model->creater->fullName?></td>
                                    <td class="text-center"><?=$model->getMembers()->count()?></td>
                                    <td ><?=$model->created_at?></td>
                                    <td ><?=$model->updated_at?></td>
                                    <?php if($project->count){?>
                                    <td >
                                        <?php if($model->isCreater() || $model->isJoiner()){?>
                                        <a class="btn btn-success btn-xs disabled mr-1">加入</a>
                                        <?=else?>
                                        <a href="javascript:;" class="btn btn-success btn-xs mr-1" data-toggle="tooltip" data-placement="bottom" data-modal="#js_popModal" data-height="140" data-title="加入项目"  data-src="<?=url('home/apply/create', ['project_id' => $model->encode_id])?>">加入</a>
                                        <?php }?>
                                        <a target="_blank" href="<?=$model->url?>" class="btn btn-warning btn-xs" data-toggle="tooltip" data-placement="bottom" data-title="查看项目">查看</a>
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
    <?php include_view(['name'=>'home/public/copyright'])?>

    <?php include_view(['name'=>'home/public/footer'])?>
