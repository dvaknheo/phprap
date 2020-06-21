<?php include_view(['name'=>'home/public/header','title'=>'用户登录'])?>

</head>

<body>

    <div class="container">
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                <div class="login-panel panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title text-center">用户登录</h3>
                    </div>
                    <div class="panel-body">
                        <form role="form" action="<?=url('login')?>" method="post">

                            <input type="hidden" name="csrf-phprap" value="<?=csrf_token()?>" />

                            <input type="hidden" name="LoginForm[callback]" value="<?=$callback?>">

                            <fieldset>
                                <div class="form-group">
                                    <input class="form-control js_email" placeholder="登录邮箱" name="LoginForm[email]" type="email" autocomplete="new-password" datatype="e" nullmsg="请输入登录邮箱" errormsg="请输入合法的邮箱地址！">
                                </div>
                                <div class="form-group">
                                    <input autocomplete="off" class="form-control js_password" placeholder="登录密码" name="LoginForm[password]" type="password" value="" autocomplete="new-password" datatype="*6-20" nullmsg="请输入登录密码" errormsg="请填写6-20个字符">
                                </div>

                                <?php if($config->login_captcha){?>
                                <div class="form-group">
                                    <div class="input-group">

                                        <input autocomplete="off" type="text" name="LoginForm[verifyCode]" class="form-control js_verifyCode" datatype="*" nullmsg="请输入验证码" placeholder="验证码，不区分大小写">

                                        <a class="input-group-btn verify-code">

                                            <img alt="点击刷新" title="点击刷新" onclick="reloadCode()" src="<?=url('home/captcha/login')?>" width="100px" height="35px">

                                        </a>

                                    </div>

                                </div>
                                <?php }?>

                                <div class="checkbox">
                                    <label>
                                        <input name="LoginForm[remember]" type="checkbox" checked value="1">记住我
                                    </label>
                                    <span class="hidden-xs pull-right">支持enter键快捷登录</span>
                                </div>
                                <!-- Change this to a button or input when using this as a form -->
                                <a href="javascript:void(0);" class="btn btn-lg btn-success btn-block" id="js_submit">立即登录</a>

                                <hr>

                                <a href="<?=url('home/account/register')?>" class="btn btn-default btn-block">还没有账号？免费注册</a>

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

        // 表单验证
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
