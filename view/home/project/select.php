<?php include_view(['name'=>'home/public/header','title'=>'选择项目'])?>

<style>
    #page-wrapper {
        position: inherit;
        margin: 0;
        padding: 0 30px;
        border-left: 1px solid #e7e7e7;
    }
    .panel-body {
        height: 80px;
        overflow: hidden;
    }

    .panel-footer {
        font-size: 12px;
        padding: 10px 15px;
        background-color: #f5f5f5;
        border-top: 1px solid #ddd;
        border-bottom-right-radius: 3px;
        border-bottom-left-radius: 3px;
        height: 40px;
    }

    .project-add,.project-search {
        height: 160px;
        overflow: hidden;
        text-align:center;
        line-height:120px;
        font-size: 36px;
    }

    .panel:hover {
        cursor: pointer;
        background:#fff;
        color:#333;
        filter:progid:DXImageTransform.Microsoft.Shadow(color=#909090,direction=120,strength=4);/*ie*/
        -moz-box-shadow: 2px 2px 10px #909090;/*firefox*/
        -webkit-box-shadow: 2px 2px 10px #909090;/*safari或chrome*/
        box-shadow:2px 2px 10px #909090;/*opera或ie9*/
    }
    .head-title{
        /*overflow: hidden;*/
        /*white-space: nowrap;*/
        text-overflow: ellipsis;
    }

    .head-btn a,.head-btn a:hover,.head-btn a:focus,.head-btn a:visited {
        text-decoration : none;
        margin: 0 0 0 10px;
        -webkit-tap-highlight-color: rgba(0, 0, 0, 0);
        outline: 0;
    }

</style>

</head>

<body>

<div id="wrapper">

    <!-- Navigation -->
    <div class="nav-box">
    <?php include_view(['name'=>'home/public/nav'])?>
    </div>
    <!-- Page Content -->
    <div id="page-wrapper" style="min-height: 680px;">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">我创建的项目</h1>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <!-- /.row -->
        <div class="row drag-contain">

            <!-- /.col-lg-4 -->
            <?php foreach($account->createdProjects as $project){?>
            <div class="col-lg-3 view-project js_viewProject pannel-project" data-url="<?=$project->url?>">
                <div class="panel panel-default">
                    <div class="panel-heading">
                    <span class="head-title"><?php if($project->isPrivate()){?><i class="fa fa-fw fa-key"></i><?php }?><?=$project->title?></span>
                        <span class="head-btn hidden pull-right">
                            <a href="javascript:;" class="fa hidden-xs fa-pencil" data-toggle="tooltip" data-placement="top" data-modal="#js_popModal"data-height="350" data-title="编辑项目" data-src="<?=url('update', ['id' => $project->encode_id])?>"></a>

                            <a  href="javascript:;" class="fa hidden-xs fa-trash-o" data-toggle="tooltip" data-placement="top" data-modal="#js_popModal" data-height="270" data-title="删除项目" data-src="<?=url('delete', ['id' => $project->encode_id])?>"></a>
                        </span>
                    </div>
                    <div class="panel-body">
                        <p class="overhidden"><?=$project->remark?></p>
                    </div>
                    <div class="panel-footer">
                        <span class="pull-left"><i class="fa fa-user fa-fw" aria-hidden="true"></i> <?=$project->creater->name?></span>
                        <span class="pull-right"><i class="fa fa-history fa-fw" aria-hidden="true"></i> <?=$project->getFriendTime($project->updated_at)?>更新</span>
                    </div>
                </div>
            </div>
            <?php }?>

            <div class="col-lg-3 hidden-xs" data-modal="#js_popModal" data-height="350" data-title="添加项目" data-src="<?=url('home/project/create')?>">
                <div class="panel panel-default">

                    <div class="panel-body project-add">
                        <p class="fa fa-plus" aria-hidden="true">添加项目</p>
                    </div>

                </div>
            </div>

        </div>

        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">我加入的项目</h1>
            </div>

        </div>

        <div class="row">

            <!-- /.col-lg-4 -->
            <?php foreach($account->joinedProjects as $project){?>
            <div class="col-lg-3 view-project js_viewProject pannel-project" data-url="<?=$project->url?>">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <span class="head-title"><?php if($project->isPrivate()){?><i class="fa fa-fw fa-key"></i><?php }?><?=$project->title?></span>
                        <span class="head-btn hidden pull-right">
                            <?php if($project->hasAuth(['project' => 'update'])){?>
                            <a href="javascript:;" class="fa hidden-xs fa-pencil" data-toggle="tooltip" data-placement="top" data-modal="#js_popModal" data-height="370" data-title="编辑项目" data-src="<?=url('update', ['id' => $project->encode_id])?>"></a>
                            <?php }?>

                            <?php if($project->hasAuth(['project' => 'delete'])){?>
                            <a href="javascript:;" class="fa hidden-xs fa-trash-o" data-toggle="tooltip" data-placement="top" data-modal="#js_popModal" data-height="270" data-title="删除项目" data-src="<?=url('delete', ['id' => $project->encode_id])?>"></a>
                            <?php }?>

                            <a href="javascript:;" class="fa hidden-xs fa-sign-out js_quitProject" data-toggle="tooltip" data-placement="top" data-modal="#js_popModal" data-height="270" data-title="退出项目"  data-src="<?=url('home/project/quit', ['id' => $project->encode_id])?>"></a>
                        </span>
                    </div>
                    <div class="panel-body">
                        <p class="overhidden"><?=$project->remark?></p>
                    </div>
                    <div class="panel-footer">
                        <span class="pull-left"><i class="fa fa-user fa-fw" aria-hidden="true"></i> <?=$project->creater->name?></span>
                        <span class="pull-right"><i class="fa fa-history fa-fw" aria-hidden="true"></i> <?=$project->getFriendTime($project->updated_at)?>更新</span>
                    </div>
                </div>
            </div>
            <?php }?>

            <div class="col-lg-3">
                <div class="panel panel-default">

                    <div class="panel-body project-search js_searchProject">
                        <p class="fa fa-search" aria-hidden="true">搜索项目</p>
                    </div>

                </div>
            </div>

        </div>

    </div>

</div>

<script>
$(function(){
    //查看项目
    $(".js_viewProject").on('click',function (e) {
        var e = e||window.event;
        e.stopPropagation();
        window.location.href = $(this).data('url');
    });

    //搜索项目
    $(".js_searchProject").on('click',function(){
        window.location.href = "<?=url('project/search')?>";
    });
});
</script>

<?php include_view(['name'=>'home/public/footer'])?>
