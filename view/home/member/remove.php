<?php include_view(['name'=>'home/public/header','title'=>'移出成员'])?>
<style>
    body {
        background-color: #ffffff;
    }
</style>
</head>

<body>

<div class="container">

    <!-- /.row -->
    <div class="row">
        <form role="form" action="<?=url()?>" method="post">

            <div class="alert alert-dismissable alert-warning">
                <i class="fa fa-fw fa-info-circle"></i>&nbsp;
                移出项目后，将失去该项目的所有权限，不可恢复，请谨慎操作！
            </div>

            <div class="well">
                <p class="text-muted"><label>项目名称：</label><?=$member->project->title?></p>
                <p class="text-muted"><label>项目创建人：</label><?=$member->project->creater->fullName?></p>
                <p class="text-muted"><label>加入时间：</label><?=$member->created_at?></p>
            </div>

            <div class="form-group">
                <input type="hidden" name="csrf-phprap" value="<?=csrf_token()?>" />

                <input name="RemoveMember[password]" type="password" class="form-control js_password" placeholder="重要操作，请输入登录密码" datatype="*" nullmsg="重要操作，请输入登录密码" errormsg="请输入正确的登录密码!">
            </div>

            <input type="hidden" id="js_submit" value="提交">

        </form>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
</div>
<!-- /#wrapper -->

<script>

$(function () {
    // 表单验证
    $("form").validateForm({
        'success':function (json) {
            parent.location.reload();
        },
    });
});

</script>

<?php include_view(['name'=>'home/public/footer'])?>
