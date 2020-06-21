<?php include_view(['name'=>'home/public/header','title'=>'删除环境'])?>
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

            <input type="hidden" name="csrf-phprap" value="<?=csrf_token()?>" />
            
            <div class="well">
                <p class="text-muted"><label>环境名称：</label><?=$env->title?>(<?=$env->name?>)</p>
                <p class="text-muted"><label>环境根路径：</label><?=$env->base_url?></p>
                <p class="text-muted"><label>创建时间：</label><?=$env->created_at?></p>
            </div>

            <div class="form-group">
                <input name="DeleteEnv[password]" type="password" class="form-control js_password" placeholder="重要操作，请输入登录密码" datatype="*" nullmsg="重要操作，请输入登录密码" errormsg="请输入正确的登录密码!">
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
