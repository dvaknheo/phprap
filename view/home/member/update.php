<?php include_view(['name'=>'home/public/header','title'=>'成员管理'])?>
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

            <input type="hidden" name="csrf-phprap" value="<?=csrf_token()?>" />

            <div class="alert alert-dismissable alert-warning">
                <i class="fa fa-fw fa-info-circle"></i>&nbsp;
                成员隶属于项目，勾选权限后，该成员具有项目的勾选权限
            </div>

            <div class="form-group">
                <label>成员信息</label>
                <input type="text" readonly class="form-control" datatype="*1-250" value="<?=$member->account->fullName?>">
            </div>

            <div class="form-group">
                <label>项目权限</label>
                <input type="hidden" class="js_projectRule" name="UpdateMember[project_rule]">
                <label class="checkbox-inline">
                    <input class="js_projectRule" onclick="return false;" checked type="checkbox" value="look">查看项目
                </label>

                <label class="checkbox-inline">
                    <input class="js_projectRule" type="checkbox" value="update" <?php if($member->hasAuth(['project' => 'update'])){?>checked<?php }?> >编辑项目
                </label>

                <label class="checkbox-inline">
                    <input class="js_projectRule" type="checkbox" value="export" <?php if($member->hasAuth(['project' => 'export'])){?>checked<?php }?> >导出项目
                </label>

                <label class="checkbox-inline">
                    <input class="js_projectRule" type="checkbox" value="history" <?php if($member->hasAuth(['project' => 'history'])){?>checked<?php }?>>项目动态
                </label>

                <label class="checkbox-inline">
                    <input class="js_projectRule" type="checkbox" value="transfer" <?php if($member->hasAuth(['project' => 'transfer'])){?>checked<?php }?> >转让项目
                </label>

                <label class="checkbox-inline">
                    <input class="js_projectRule" type="checkbox" value="delete" <?php if($member->hasAuth(['project' => 'delete'])){?>checked<?php }?> >删除项目
                </label>
            </div>

            <div class="form-group">
                <label>环境权限</label>
                <input type="hidden" class="js_envRule" name="UpdateMember[env_rule]">
                <label class="checkbox-inline">
                    <input class="js_envRule" onclick="return false;" checked type="checkbox" value="look">查看环境
                </label>
                <label class="checkbox-inline">
                    <input class="js_envRule" type="checkbox" <?php if($member->hasAuth(['env' => 'create'])){?>checked<?php }?> value="create">新增环境
                </label>
                <label class="checkbox-inline">
                    <input class="js_envRule" type="checkbox" <?php if($member->hasAuth(['env' => 'update'])){?>checked<?php }?> value="update">编辑环境
                </label>
                <label class="checkbox-inline">
                    <input class="js_envRule" type="checkbox" <?php if($member->hasAuth(['env' => 'delete'])){?>checked<?php }?> value="delete">删除环境
                </label>
            </div>

            <div class="form-group">
                <label>模板权限</label>
                <input type="hidden" class="js_templateRule" name="UpdateMember[template_rule]">
                <label class="checkbox-inline">
                    <input class="js_templateRule" <?php if($member->hasAuth(['template' => 'look'])){?>checked<?php }?> type="checkbox" value="look">查看模板
                </label>
                <label class="checkbox-inline">
                    <input class="js_templateRule" type="checkbox" <?php if($member->hasAuth(['template' => 'create'])){?>checked<?php }?> value="create">新增模板
                </label>
                <label class="checkbox-inline">
                    <input class="js_templateRule" type="checkbox" <?php if($member->hasAuth(['template' => 'update'])){?>checked<?php }?> value="update">编辑模板
                </label>
            </div>

            <div class="form-group">
                <label>模块权限</label>
                <input type="hidden" class="js_moduleRule" name="UpdateMember[module_rule]">
                <label class="checkbox-inline">
                    <input class="js_moduleRule" onclick="return false;" checked type="checkbox" value="look">查看模块
                </label>
                <label class="checkbox-inline">
                    <input class="js_moduleRule" type="checkbox" <?php if($member->hasAuth(['module' => 'create'])){?>checked<?php }?> value="create">新增模块
                </label>
                <label class="checkbox-inline">
                    <input class="js_moduleRule" type="checkbox" <?php if($member->hasAuth(['module' => 'update'])){?>checked<?php }?> value="update">编辑模块
                </label>
                <label class="checkbox-inline">
                    <input class="js_moduleRule" type="checkbox" <?php if($member->hasAuth(['module' => 'delete'])){?>checked<?php }?> value="delete">删除模块
                </label>
            </div>

            <div class="form-group">
                <label>接口权限</label>
                <input type="hidden" class="js_apiRule" name="UpdateMember[api_rule]">

                <label class="checkbox-inline">
                    <input class="js_apiRule" onclick="return false;" checked type="checkbox" value="look">查看接口
                </label>
                <label class="checkbox-inline">
                    <input class="js_apiRule" type="checkbox" <?php if($member->hasAuth(['api' => 'create'])){?>checked<?php }?> value="create">新增接口
                </label>

                <label class="checkbox-inline">
                    <input class="js_apiRule" type="checkbox" <?php if($member->hasAuth(['api' => 'update'])){?>checked<?php }?> value="update">编辑接口
                </label>

                <label class="checkbox-inline">
                    <input class="js_apiRule" type="checkbox" <?php if($member->hasAuth(['api' => 'debug'])){?>checked<?php }?> value="debug">接口调试
                </label>

                <label class="checkbox-inline">
                    <input class="js_apiRule" type="checkbox" <?php if($member->hasAuth(['api' => 'export'])){?>checked<?php }?> value="export">导出接口
                </label>
                <label class="checkbox-inline">
                    <input class="js_apiRule" type="checkbox" <?php if($member->hasAuth(['api' => 'history'])){?>checked<?php }?> value="history">接口动态
                </label>
                <label class="checkbox-inline">
                    <input class="js_apiRule" type="checkbox" <?php if($member->hasAuth(['api' => 'delete'])){?>checked<?php }?> value="delete">删除接口
                </label>
            </div>

            <div class="form-group">
                <label>成员权限</label>
                <input type="hidden" class="js_memberRule" name="UpdateMember[member_rule]">
                <label class="checkbox-inline">
                    <input class="js_memberRule" type="checkbox" <?php if($member->hasAuth(['member' => 'look'])){?>checked<?php }?> value="look">查看成员
                </label>
                <label class="checkbox-inline">
                    <input class="js_memberRule" type="checkbox" <?php if($member->hasAuth(['member' => 'create'])){?>checked<?php }?> value="create">添加成员
                </label>

                <label class="checkbox-inline">
                    <input class="js_memberRule" type="checkbox" <?php if($member->hasAuth(['member' => 'update'])){?>checked<?php }?> value="update">编辑成员
                </label>
                <label class="checkbox-inline">
                    <input class="js_memberRule" type="checkbox" <?php if($member->hasAuth(['member' => 'remove'])){?>checked<?php }?> value="remove">移除成员
                </label>
            </div>

            <input type="hidden" id="js_submit" value="提交">

        </form>

        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
</div>
<!-- /#wrapper -->

<script>
$(function(){
    // 表单验证
    $("form").validateForm({
        'before':function (json) {
            // 项目权限
            var projectRule =[];
            $(".js_projectRule:checkbox:checked").each(function(){
                projectRule.push($(this).val());
            });
            $(".js_projectRule:hidden").val(projectRule.join(','));

            // 环境权限
            var envRule =[];
            $(".js_envRule:checkbox:checked").each(function(){
                envRule.push($(this).val());
            });
            $(".js_envRule:hidden").val(envRule.join(','));

            // 模板权限
            var templateRule =[];
            $(".js_templateRule:checkbox:checked").each(function(){
                templateRule.push($(this).val());
            });
            $(".js_templateRule:hidden").val(templateRule.join(','));

            // 模块权限
            var moduleRule =[];
            $(".js_moduleRule:checkbox:checked").each(function(){
                moduleRule.push($(this).val());
            });
            $(".js_moduleRule:hidden").val(moduleRule.join(','));

            // 接口权限
            var apiRule =[];
            $(".js_apiRule:checkbox:checked").each(function(){
                apiRule.push($(this).val());
            });
            $(".js_apiRule:hidden").val(apiRule.join(','));

            // 成员权限
            var memberRule =[];
            $(".js_memberRule:checkbox:checked").each(function(){
                memberRule.push($(this).val());
            });
            $(".js_memberRule:hidden").val(memberRule.join(','));

        }
    });
});
</script>
<?php include_view(['name'=>'home/public/footer'])?>
