<?php include_view(['name'=>'home/public/header','title'=>'申请管理'])?>

</head>

<body>

<div id="wrapper">

    <!-- Navigation -->
    <?php include_view(['name'=>'home/public/nav','sidebar'=>'home/account/sidebar','active'=>'apply'])?>
    <div id="page-wrapper">

        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">审核历史
                    <small>(<?=$model->count?>)</small>
                </h1>
                <div class="search">
                    <div class="row">
                        <form action="" method="get" autocomplete="off">

                            <div class="col-sm-4">
                                <div class="form-group">
                                    <input name="user[name]" type="text" class="form-control" placeholder="创建人昵称或邮箱，支持模糊查询" value="<?=$model->params->user->name?>">
                                </div>
                            </div>

                            <div class="col-sm-4">
                                <div class="form-group">
                                    <input name="title" type="text" class="form-control" placeholder="项目名称，支持模糊查询" value="<?=$model->params->title?>">
                                </div>
                            </div>

                            <div class="col-sm-4">
                                <div class="form-group">
                                    <select class="form-control" name="status">
                                        <option disabled="" selected="" style="display:none;">处理结果</option>
                                        <option value="">不限</option>
                                        <?php foreach($model->statusLabels as $k1 => $v1){?>
                                        <?php if($k1 != $model::CHECK_STATUS){?>
                                        <option value="<?=$k1?>" <?php if($model->params->status == $k1){?>selected<?php }?>><?=$v1?></option>
                                        <?php }?>
                                        <?php }?>
                                    </select>
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

                    <?php include_view(['name'=>'home/apply/tab','tab'=>'history'])?>

                    <!-- /.panel-heading -->
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th>申请人昵称/账号</th>
                                    <th>申请加入的项目</th>
                                    <th>项目类型</th>

                                    <th class="datetime">申请时间</th>
                                    <th>处理结果</th>
                                    <th class="datetime">处理时间</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php foreach($model->models as $model){?>
                                <tr>
                                    <td ><?=$model->applier->fullName?></td>
                                    <td ><?=$model->project->title?></td>
                                    <td ><?=$model->project->typeLabel?></td>
                                    <td ><?=$model->created_at?></td>

                                    <td >
                                        <?php if($model->status == $model::PASS_STATUS){?>
                                        <span class="text-success"><?=$model->statusLabel?></span>
                                        <?=else if $model->status == $model::REFUSE_STATUS?>
                                        <span class="text-danger"><?=$model->statusLabel?></span>
                                        <?php }?>
                                    </td>
                                    <td ><?=$model->checked_at?></td>
                                </tr>
                                <?php }?>

                                </tbody>
                            </table>
                        </div>

                        <?=$model->pages?>
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
