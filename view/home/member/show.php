<?php include_view(['name'=>'home/public/header','title'=>'查看成员'])?>
<style>
    body {
        background-color: #ffffff;
    }

    table a{
        margin-top: 10px;
    }
</style>
</head>

<body>

<div class="container">

    <!-- /.row -->
    <div class="row">

        <form role="form" action="<?=url()?>" method="post">

            <div class="form-group">
                <label>成员信息</label>
                <input type="text" readonly class="form-control" value="<?=$member->account->fullName?>">
            </div>

            <div class="form-group">
                <label>加入时间</label>
                <input type="text" readonly class="form-control" value="<?=$member->created_at?>">
            </div>

            <div class="form-group">
                <label>项目权限</label>
                <input type="hidden" class="js_projectRule">
                <label class="checkbox-inline">
                    <input class="js_projectRule" disabled onclick="return false;" checked type="checkbox" value="look">查看项目
                </label>

                <label class="checkbox-inline">
                    <input class="js_projectRule" disabled type="checkbox" value="update" <?php if($member->hasAuth(['project' => 'update'])){?>checked<?php }?> >编辑项目
                </label>

                <label class="checkbox-inline">
                    <input class="js_projectRule" disabled type="checkbox" value="export" <?php if($member->hasAuth(['project' => 'export'])){?>checked<?php }?> >导出项目
                </label>

                <label class="checkbox-inline">
                    <input class="js_projectRule" disabled type="checkbox" value="delete" <?php if($member->hasAuth(['project' => 'create'])){?>checked<?php }?> >删除项目
                </label>
            </div>

            <div class="form-group">
                <label>环境权限</label>
                <input type="hidden" class="js_envRule">
                <label class="checkbox-inline">
                    <input class="js_envRule" disabled onclick="return false;" checked type="checkbox" value="look">查看环境
                </label>
                <label class="checkbox-inline">
                    <input class="js_envRule" disabled type="checkbox" <?php if($member->hasAuth(['env' => 'create'])){?>checked<?php }?> value="create">新增环境
                </label>
                <label class="checkbox-inline">
                    <input class="js_envRule" disabled type="checkbox" <?php if($member->hasAuth(['env' => 'update'])){?>checked<?php }?> value="update">编辑环境
                </label>
                <label class="checkbox-inline">
                    <input class="js_envRule" disabled type="checkbox" <?php if($member->hasAuth(['env' => 'delete'])){?>checked<?php }?> value="delete">删除环境
                </label>
            </div>

            <div class="form-group">
                <label>模块权限</label>
                <input type="hidden" class="js_moduleRule">
                <label class="checkbox-inline">
                    <input class="js_moduleRule" disabled onclick="return false;" checked type="checkbox" value="look">查看模块
                </label>
                <label class="checkbox-inline">
                    <input class="js_moduleRule" disabled type="checkbox" <?php if($member->hasAuth(['module' => 'create'])){?>checked<?php }?> value="create">新增模块
                </label>
                <label class="checkbox-inline">
                    <input class="js_moduleRule" disabled type="checkbox" <?php if($member->hasAuth(['module' => 'update'])){?>checked<?php }?> value="update">编辑模块
                </label>
                <label class="checkbox-inline">
                    <input class="js_moduleRule" disabled type="checkbox" <?php if($member->hasAuth(['module' => 'delete'])){?>checked<?php }?> value="delete">删除模块
                </label>
            </div>

            <div class="form-group">
                <label>接口权限</label>
                <input type="hidden" class="js_apiRule">

                <label class="checkbox-inline">
                    <input class="js_apiRule" disabled onclick="return false;" checked type="checkbox" value="look">查看接口
                </label>
                <label class="checkbox-inline">
                    <input class="js_apiRule" disabled type="checkbox" <?php if($member->hasAuth(['api' => 'create'])){?>checked<?php }?> value="create">新增接口
                </label>

                <label class="checkbox-inline">
                    <input class="js_apiRule" disabled type="checkbox" <?php if($member->hasAuth(['api' => 'update'])){?>checked<?php }?> value="update">编辑接口
                </label>
                <label class="checkbox-inline">
                    <input class="js_apiRule" disabled type="checkbox" <?php if($member->hasAuth(['api' => 'export'])){?>checked<?php }?> value="field">导出接口
                </label>
                <label class="checkbox-inline">
                    <input class="js_apiRule" disabled type="checkbox" <?php if($member->hasAuth(['api' => 'delete'])){?>checked<?php }?> value="delete">删除接口
                </label>
            </div>

            <div class="form-group">
                <label>成员权限</label>
                <input type="hidden" class="js_memberRule">
                <label class="checkbox-inline">
                    <input class="js_memberRule" disabled onclick="return false;" checked type="checkbox" value="look">查看成员
                </label>
                <label class="checkbox-inline">
                    <input class="js_memberRule" disabled type="checkbox" <?php if($member->hasAuth(['member' => 'create'])){?>checked<?php }?> value="create">添加成员
                </label>

                <label class="checkbox-inline">
                    <input class="js_memberRule" disabled type="checkbox" <?php if($member->hasAuth(['member' => 'update'])){?>checked<?php }?> value="update">编辑成员
                </label>
                <label class="checkbox-inline">
                    <input class="js_memberRule" disabled type="checkbox" <?php if($member->hasAuth(['member' => 'remove'])){?>checked<?php }?> value="remove">移除成员
                </label>
            </div>

        </form>

        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
</div>
<!-- /#wrapper -->

<?php include_view(['name'=>'home/public/footer'])?>
