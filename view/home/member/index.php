<?php include_view(['name'=>'home/public/header','title'=>'项目成员'])?>

</head>

<body>

<div id="wrapper">

    <!-- Navigation -->
    <?php include_view(['name'=>'home/public/nav','sidebar'=>'home/project/sidebar'])?>
    <div id="page-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <div class="page-header">
                    <h1>项目成员
                        <small>(<?=$member->count?>)</small>
                    </h1>

                    <div class="opt-btn">
                        <?php if($project->hasAuth(['member' => 'create'])){?>
                        <a href="javascript:void(0);" class="btn hidden-xs btn-sm btn-success" data-title='添加成员' data-modal="#js_popModal" data-width="760" data-height="340" data-src="<?=url('member/create', ['project_id' => $project->encode_id])?>"><i class="fa fa-fw fa-plus"></i>添加</a>
                        <?php }?>
                    </div>
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
                            <input name="tab" type="hidden" value="member">
                            
                            <div class="col-sm-4">

                                <div class="form-group">
                                    <input name="user[name]" type="text" class="form-control" placeholder="成员昵称或邮箱，支持模糊查询" value="<?=$member->params->user->name?>">
                                </div>
                            </div>

                            <div class="col-sm-4">

                                <div class="form-group">
                                    <select class="form-control" name="join_type">
                                        <option disabled="" selected="" style="display:none;">加入方式</option>
                                        <option value="">不限</option>
                                        <?php foreach($member->joinTypeLabels as $k => $v){?>
                                        <option value="<?=$k?>" <?php if($member->params->join_type == $k){?>selected<?php }?>><?=$v?></option>
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

                    <?php include_view(['name'=>'home/project/tab','tab'=>'member'])?>

                    <div class="panel-body">
                        <div class="table-responsive ">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th>成员昵称/账号</th>
                                    <th>加入方式</th>
                                    <th>审核/邀请者</th>
                                    <th class="datetime">加入时间</th>
                                    <th class="datetime">更新时间</th>
                                    <?php if($member->count){?>
                                    <th class="hidden-xs" width="95px"></th>
                                    <?php }?>
                                </tr>
                                </thead>
                                <tbody>
                                <?php foreach($member->models as $model){?>

                                <tr>
                                    <td><?=$model->account->fullName?></td>
                                    <td><?=$model->joinTypeLabel?></td>

                                    <td><?=$model->creater->fullName?></td>

                                    <td><?=$model->created_at?></td>
                                    <td><?=$model->updated_at?></td>
                                    <?php if($member->count){?>
                                    <td class="hidden-xs">

                                        <?php if($project->hasAuth(['member' => 'update'])){?>
                                        <a type="button" class="btn btn-success btn-xs mr-1" data-toggle="tooltip" data-placement="top" data-title="编辑成员" data-modal="#js_popModal" data-width="760" data-height="350" data-src="<?=url('home/member/update', ['id' => $model->encode_id])?>">编辑</a>
                                        <?php }else{?>
                                        <a type="button" class="btn btn-success btn-xs mr-1" data-toggle="tooltip" data-placement="top" data-title="查看成员" data-modal="#js_popModal" data-width="760" data-height="350" data-ok-btn-show="false" data-src="<?=url('home/member/show', ['id' => $model->encode_id])?>">查看</a>
                                        <?php }?>

                                        <?php if($project->hasAuth(['member' => 'remove'])){?>
                                        <a type="button" class="btn btn-danger btn-xs" data-toggle="tooltip" data-placement="top" data-title="移出项目" data-modal="#js_popModal" data-height="270" data-src="<?=url('home/member/remove', ['id' => $model->encode_id])?>">移出</a>
                                        <?php }?>
                                    </td>
                                    <?php }?>
                                </tr>

                                <?php }?>

                                </tbody>
                            </table>
                            <?=$member->pages?>
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