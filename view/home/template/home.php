<?php include_view(['name'=>'home/public/header','title'=>'项目模板'])?>
<style>
    .table>thead>tr>th, .table>tbody>tr>th, .table>tfoot>tr>th, .table>thead>tr>td, .table>tbody>tr>td, .table>tfoot>tr>td {
        padding: 8px 8px 8px 0;
        line-height: 1.42857143;
        vertical-align: top;
        border-top: 1px solid #ddd;
    }
    .table>tbody>tr.level1>td, .table>tbody>tr.level1>th, .table>tbody>tr>td.level1, .table>tbody>tr>th.level1, .table>tfoot>tr.level1>td, .table>tfoot>tr.level1>th, .table>tfoot>tr>td.level1, .table>tfoot>tr>th.level1, .table>thead>tr.level1>td, .table>thead>tr.level1>th, .table>thead>tr>td.level1, .table>thead>tr>th.level1 {
        background-color: #f5f5f5;
    }
    .table>tbody>tr.level2>td, .table>tbody>tr.level2>th, .table>tbody>tr>td.level2, .table>tbody>tr>th.level2, .table>tfoot>tr.level2>td, .table>tfoot>tr.level2>th, .table>tfoot>tr>td.level2, .table>tfoot>tr>th.level2, .table>thead>tr.level2>td, .table>thead>tr.level2>th, .table>thead>tr>td.level2, .table>thead>tr>th.level2 {
        background-color: rgba(255,255,255,.15);
    }
</style>
</head>

<body>

<div id="wrapper">

    <!-- Navigation -->
    <?php include_view(['name'=>'home/public/nav','sidebar'=>'home/project/sidebar'])?>
    <div id="page-wrapper">

        <div class="row">
            <div class="col-lg-12">
                <div class="page-header">
                    <h1>项目模板 </h1>
                    <div class="opt-btn">
                        <?php if($project->template->id){?>
                        <a href="<?=url('home/template/update', ['id' => $template->encode_id])?>" class="btn hidden-xs btn-sm btn-warning"><i class="fa fa-fw fa-plus"></i>编辑</a>
                        <?=else?>
                        <a href="<?=url('home/template/create', ['project_id' => $project->encode_id])?>" class="btn hidden-xs btn-sm btn-success"><i class="fa fa-fw fa-plus"></i>添加</a>
                        <?php }?>
                    </div>
                </div>
            </div>
            <!-- /.col-lg-12 -->
        </div>

        <!-- 接口详情 -->
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">

                    <?php include_view(['name'=>'home/project/tab','tab'=>'template'])?>

                    <div class="panel-body">
                        <div class="alert alert-warning alert-dismissable">
                            <i class="fa fa-fw fa-info-circle"></i>
                            项目模板里的参数会在新建接口时默认自动填充到接口字段里，可以减少公共参数的手工录入成本。
                        </div>
                        <!--header参数-->
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        Header参数
                                    </div>
                                    <!-- /.panel-heading -->
                                    <div class="panel-body">
                                        <div class="table-responsive">
                                            <table class="table">
                                                <thead>
                                                <tr>
                                                    <th width="200px">参数名</th>
                                                    <th width="200px">参数标题</th>
                                                    <th width="100px">参数类型</th>
                                                    <th width="60px">必填</th>
                                                    <th width="90px">参数值</th>
                                                    <th>备注说明</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <?php foreach($template->headerAttributes as $header){?>
                                                <tr class="level<?=$header->level?>">
                                                    <td>
                                                        <?php if($header->level){?>
                                                        <?=str_repeat('&nbsp;&nbsp;&nbsp;', $header->level)?>
                                                        <i class="fa fa-fw fa-angle-right fa-1" aria-hidden="true"></i>
                                                        <?php }?>
                                                        <?=$header->name?>
                                                    </td>
                                                    <td><?=$header->title?></td>

                                                    <td><?=$field->fieldTypeLabels[$header->type]?></td>
                                                    <td><?=$field->requiredLabels[$header->required]?></td>

                                                    <td><?=$header->value?></td>
                                                    <td><?=$header->remark?></td>
                                                </tr>
                                                <?php }?>

                                                </tbody>
                                            </table>
                                        </div>
                                        <!-- /.table-responsive -->
                                    </div>
                                    <!-- /.panel-body -->
                                </div>
                                <!-- /.panel -->
                            </div>
                            <!-- /.col-lg-6 -->
                        </div>
                        <!--请求参数-->
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        请求参数
                                    </div>
                                    <!-- /.panel-heading -->
                                    <div class="panel-body">
                                        <div class="table-responsive">
                                            <table class="table">
                                                <thead>
                                                <tr>
                                                    <th width="200px">参数名</th>
                                                    <th width="200px">参数标题</th>
                                                    <th width="120px">参数类型</th>
                                                    <th width="60px">必填</th>
                                                    <th width="90px">默认值</th>
                                                    <th>备注说明</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <?php foreach($template->requestAttributes as $request){?>
                                                <tr class="level<?=$request->level?>">
                                                    <td>
                                                        <?php if($request->level){?>
                                                        <?=str_repeat('&nbsp;&nbsp;&nbsp;', $request->level)?>
                                                        <i class="fa fa-fw fa-angle-right fa-1" aria-hidden="true"></i>
                                                        <?php }?>
                                                        <?=$request->name?>
                                                    </td>
                                                    <td><?=$request->title?></td>
                                                    <td><?=$field->fieldTypeLabels[$request->type]?></td>
                                                    <td><?=$field->requiredLabels[$request->required]?></td>
                                                    <td><?=$request->default?></td>
                                                    <td><?=$request->remark?></td>
                                                </tr>
                                                <?php }?>
                                                </tbody>
                                            </table>
                                        </div>
                                        <!-- /.table-responsive -->
                                    </div>
                                    <!-- /.panel-body -->
                                </div>
                                <!-- /.panel -->
                            </div>
                            <!-- /.col-lg-6 -->
                        </div>
                        <!--响应参数-->
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        响应参数
                                    </div>
                                    <!-- /.panel-heading -->
                                    <div class="panel-body">
                                        <div class="table-responsive">
                                            <table class="table">
                                                <thead>
                                                <tr>
                                                    <th width="200px">参数名</th>
                                                    <th width="200px">参数标题</th>
                                                    <th width="120px">参数类型</th>
                                                    <th width="200px">MOCK规则</th>
                                                    <th>备注说明</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <?php foreach($template->responseAttributes as $response){?>
                                                <tr class="level<?=$response->level?>">
                                                    <td>
                                                        <?php if($response->level){?>
                                                        <?=str_repeat('&nbsp;&nbsp;&nbsp;', $response->level)?>
                                                        <i class="fa fa-fw fa-angle-right fa-1" aria-hidden="true"></i>
                                                        <?php }?>
                                                        <?=$response->name?>
                                                    </td>
                                                    <td><?=$response->title?></td>
                                                    <td><?=$field->fieldTypeLabels[$response->type]?></td>
                                                    <td><?=$response->mock?></td>
                                                    <td><?=$response->description?></td>
                                                </tr>
                                                <?php }?>
                                                </tbody>
                                            </table>
                                        </div>
                                        <!-- /.table-responsive -->
                                    </div>
                                    <!-- /.panel-body -->
                                </div>
                                <!-- /.panel -->
                            </div>
                            <!-- /.col-lg-6 -->
                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>
    <!-- /#page-wrapper -->

</div>

<!-- /#wrapper -->
<?php include_view(['name'=>'home/public/copyright'])?>

<script>
    $(function () {
        // 未设置环境弹框提示
        <?php if($project->getEnvs()->count() == 0){?>
        confirm('项目至少需要设置一个环境，请立即设置', function(){
            window.location.href = "<?=url('project/show', ['id' => $project->encode_id, 'tab' => 'env'])?>";
        });
        <?php }?>
    });
</script>
<?php include_view(['name'=>'home/public/footer'])?>