<?php include_view(['name'=>'home/public/header','title'=>'修改密码'])?>
<style>
    body {
        background-color: #ffffff;
    }
    .container {
        min-height: 200px;
    }
</style>
</head>

<body>

<div class="container">
    <!-- /.row -->
    <div class="row">
        <form role="form" action="<?=url('')?>" method="post">

            <input type="hidden" name="csrf-phprap" value="<?=csrf_token()?>" />

            <div class="alert alert-dismissable alert-warning">
                <i class="fa fa-fw fa-info-circle"></i>&nbsp;
                如果忘记原始密码，请联系系统管理员重置密码
            </div>

            <div class="form-group">
                <label>原始密码</label>
                <input class="form-control js_old_password" name="PasswordForm[old_password]" type="password" autocomplete="new-password" placeholder="请输入原始密码" datatype="*2-250" nullmsg="请输入原始密码">
            </div>

            <div class="form-group">
                <label>登录密码</label>
                <input class="form-control js_new_password" name="PasswordForm[new_password]" type="password" autocomplete="new-password" placeholder="登录密码，不少于6位，修改密码后需要重新登录" value="" autocomplete="new-password" datatype="*6-20" nullmsg="请填写登录密码" errormsg="请填写6-20个字符">
            </div>

            <div class="form-group">
                <label>确认密码</label>
                <input class="form-control" type="password" placeholder="请再次输入登录密码" autocomplete="new-password" datatype="*" recheck="PasswordForm[new_password]" nullmsg="请输入确认密码" errormsg="确认密码与密码不一致">
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
    $("form").validateForm();
});

</script>

<?php include_view(['name'=>'home/public/footer'])?>
