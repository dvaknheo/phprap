<?php include_view(['name'=>'home/public/header','title'=>'项目动态'])?>
<style>
    .pagination {
        margin: 10px 0 0 0;
    }
    .timeline-badge {
        z-index: 100;
        top: 16px;
        left: 50%;
        width: 50px;
        height: 50px;
        border-radius: 50% 50% 50% 50%;
        text-align: center;
        font-size: 1.4em;
        line-height: 50px;
        color: #fff;
        background-color: #999999;
    }
    .timeline-badge.delete {
        background-color: #d9534f !important;
    }
    .timeline-badge.create {
        background-color: #3f903f !important;
    }
    .timeline-badge.update {
        background-color: #337ab7 !important;
    }

    .timeline-badge.export {
        background-color: #f0ad4e !important;
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
                    <h1>项目动态
                        <small>(<?=$history->count?>)</small>
                    </h1>

                </div>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <!-- /.row -->
        <div class="row">

            <div class="col-lg-12">

                <div class="search">
                    <div class="row">
                        <form action="<?=url()?>" method="get" autocomplete="off">
                            <input name="tab" type="hidden" value="history">

                            <div class="col-sm-4">

                                <div class="form-group">
                                    <select class="form-control" name="object_name">
                                        <option disabled="" selected="" style="display:none;">操作对象</option>
                                        <option value="">不限</option>
                                        <?php foreach($history->objectLabels as $k => $v){?>
                                        <?php if($k != 'api'){?>
                                        <option value="<?=$k?>" <?php if($history->params->object_name == $k){?>selected<?php }?>><?=$v?></option>
                                        <?php }?>
                                        <?php }?>

                                    </select>
                                </div>

                            </div>

                            <div class="col-sm-4">

                                <div class="form-group">
                                    <select class="form-control" name="type">
                                        <option disabled="" selected="" style="display:none;">操作行为</option>
                                        <option value="">不限</option>
                                        <?php foreach($history->typeLabels as $k => $v){?>
                                        <option value="<?=$k?>" <?php if($history->params->type == $k){?>selected<?php }?>><?=$v?></option>
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

                <div class="panel panel-default">

                    <?php include_view(['name'=>'home/project/tab','tab'=>'history'])?>


                    <div class="panel-body">
                        <ul class="chat">
                            <?php foreach($history->models as $model){?>
                            <li class="left clearfix">
                                <?php if($model->type == 'delete'){?>
                                <div class="timeline-badge delete pull-left"><i class="fa fa-fw fa-trash-o"></i></div>
                                <?php }else if ($model->type == 'export'){?>
                                <div class="timeline-badge export pull-left"><i class="fa fa-fw fa-download"></i></div>
                                <?php }else if ($model->type == 'create'){?>
                                <div class="timeline-badge create pull-left"><i class="fa fa-fw fa-plus"></i></div>
                                <?php }else if ($model->type == 'update'){?>
                                <div class="timeline-badge update pull-left"><i class="fa fa-fw fa-edit"></i></div>
                                <?php }?>

                                <div class="chat-body clearfix">
                                    <div class="header">
                                        <strong class="primary-font"><?=$model->account->fullName?></strong>
                                        <small class="pull-right text-muted">
                                            <i class="fa fa-clock-o fa-fw"></i> <?=$history->getFriendTime($model->created_at)?>
                                        </small>
                                    </div>
                                    <p>
                                        <?=$model->content?>
                                    </p>
                                </div>
                            </li>
                            <?php }?>
                        </ul>
                        <?=$history->pages?>
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

<?php include_view(['name'=>'home/public/copyright'])?>

<script>
$(function () {

    // 未设置环境弹框提示
    <?php if($project->getEnvsCount() == 0){?>
    confirm('项目至少需要设置一个环境，请立即设置', function(){

        window.location.href = "<?=url('project/show', ['id' => $project->encode_id, 'tab' => 'env'])?>";

    });
    <?php }?>
});
</script>
<?php include_view(['name'=>'home/public/footer','has_copyright'=>'true'])?>