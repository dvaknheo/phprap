<?php include_view(['name'=>'home/public/header','title'=>'删除模块'])?>
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
                点击确认后，该模块及模块下所有接口将被立刻删除，不可恢复，请谨慎操作！
            </div>

            <div class="well">
                <p class="text-muted"><label>删除的模块：</label><?=$module->title?></p>
                <p class="text-muted"><label>模块创建人：</label><?=$module->creater->name?>(<?=$module->creater->email?>)</p>
            </div>

            <div class="form-group">
                <input type="hidden" name="csrf-phprap" value="<?=csrf_token()?>" />

                <input name="DeleteModule[password]" type="password" class="form-control js_password" placeholder="重要操作，请输入登录密码" datatype="*" nullmsg="重要操作，请输入登录密码" errormsg="请输入正确的登录密码!">
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
    $("form").validateForm();
});

</script>

<?php include_view(['name'=>'home/public/footer'])?>
