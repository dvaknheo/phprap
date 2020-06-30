<?php include_view(['name'=>'home/public/header','title'=>"登录历史" ])?>

</head>

<body>

<div id="wrapper">

    <!-- Navigation -->
    <?php include_view(['name'=>'home/public/nav','sidebar'=>'admin/public/sidebar','active'=>'history'])?>
    <div id="page-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">登录历史
                    <small>(<?=$model->count?>)</small>
                </h1>

                <div class="search">
                    <div class="row">
                        <form action="<?=url()?>" method="get" autocomplete="off">

                            <div class="col-sm-4">
                                <div class="form-group">
                                    <input name="user[name]" type="text" class="form-control" placeholder="登录昵称或邮箱，支持模糊查询" value="<?=$params->user->name?>">
                                </div>
                            </div>


                            <div class="col-sm-4">

                                <div class="form-group">
                                    <input name="ip" type="text" class="form-control" placeholder="登录IP，支持模糊查询" value="<?=$params->ip?>">
                                </div>
                            </div>

                            <div class="col-sm-4">

                                <div class="form-group">
                                    <input name="location" type="text" class="form-control" placeholder="登录地点，支持模糊查询" value="<?=$params->location?>">
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

                    <!-- /.panel-heading -->
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th>登录昵称/账号</th>
                                    <th>登录时间</th>
                                    <th>登录IP</th>
                                    <th>登录地点</th>
                                    <th>登录设备</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php foreach($model->models as $v){?>

                                <tr>
                                    <td><?=$v->user_name?>(<?=$v->user_email?>)</td>
                                    <td class="datetime"><?=$v->created_at?></td>
                                    <td><?=$v->ip?></td>
                                    <td><?=$v->location?></td>
                                    <td><?=$v->os?> <?=$v->browser?></td>
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

    <?php include_view(['name'=>'home/public/footer'])?>