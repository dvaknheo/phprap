<?php include_view(['name'=>'home/public/header','title'=>'用户注册'])?>

</head>

<body>

    <div class="container">
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                <div class="login-panel panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title text-center">用户注册</h3>
                    </div>
                    <div class="panel-body">
                        <form role="form" action="<?=url('register')?>" method="post">

                            <fieldset>

                                <input type="hidden" name="csrf-phprap" value="<?=csrf_token()?>" />

                                <div class="form-group">
                                    <input autocomplete="off" type="text" class="form-control js_email" placeholder="登录邮箱，必填" name="RegisterForm[email]" datatype="e" nullmsg="请输入登录邮箱" errormsg="请输入合法的邮箱地址" >
                                </div>

                                <div class="form-group">
                                    <input autocomplete="off" type="text" class="form-control js_name" placeholder="用户昵称，必填，建议写真实姓名以方便识别" name="RegisterForm[name]" datatype="*2-10" nullmsg="请输入用户昵称" errormsg="请输入2-10个由字母或汉字组成的字符">
                                </div>

                                <div class="form-group">
                                    <input autocomplete="off" type="password" class="form-control js_password" placeholder="登录密码，必填，不少于6位" name="RegisterForm[password]" datatype="*6-20" nullmsg="请输入登录密码" errormsg="请填写6-20个字符">
                                </div>

                                <div class="form-group">
                                    <input autocomplete="off" type="password" class="form-control" placeholder="请再次输入确认密码" datatype="*" recheck="RegisterForm[password]" nullmsg="请输入重复密码" errormsg="两次密码输入不一致">
                                </div>

                                <?php if($config->register_token){?>
                                <div class="form-group">
                                    <input autocomplete="off" type="text" class="form-control js_registerToken" placeholder="注册邀请码，必填，区分大小写" datatype="*" nullmsg="请输入注册口令" name="RegisterForm[registerToken]" datatype="*">
                                </div>
                                <?php }?>

                                <?php if($config->register_captcha){?>
                                <div class="form-group">
                                    <div class="input-group">

                                        <input autocomplete="off" class="form-control js_verifyCode" type="text" name="RegisterForm[verifyCode]" datatype="*" nullmsg="请输入验证码" placeholder="验证码，不区分大小写">

                                        <a class="input-group-btn verify-code">

                                           <img alt="点击刷新" title="点击刷新" onclick="reloadCode()" src="<?=url('home/captcha/register')?>">

                                        </a>

                                    </div>

                                </div>
                                <?php }?>

                                <!-- Change this to a button or input when using this as a form -->
                                <a href="javascript:void(0);" class="btn btn-lg btn-success btn-block" id="js_submit">快速注册</a>

                                <hr>

                                <a href="<?=url('home/account/login')?>" class="btn btn-default btn-block">已有账号，直接登录</a>

                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <?php include_view(['name'=>'home/public/copyright'])?>
    </div>

<script>
// 刷新验证码
function reloadCode() {

    var img = $(".verify-code").find('img');

    if(!img){
        return false;
    }

    var src = img.attr("src");

    if(!src){
        return false;
    }

    var src = img.attr("src").split('?');

    img.attr("src", src[0]+'?random='+new Date().getTime());

}

$(function(){
    // enter键快速提交
    $('body').bind('keypress',function(event){
        if(event.keyCode == "13") {
            $('form').trigger('submit');
        }
    });

    //注册表单验证
    $("form").validateForm({
        'success':function (json) {
            if(json.callback){
                window.location.href = json.callback;
            }else{
                window.location.reload();
            }
        },
        'error':function (json) {
            $(".js_verifyCode").val('');
            reloadCode();
        }
    });
})
</script>

<?php include_view(['name'=>'home/public/footer'])?>
