<?php include_view(['name'=>'home/public/header','title'=>'环境管理'])?>
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
            <div class="form-group">
                <label class="control-label">环境名称</label>
                <input type="text" class="form-control js_title" name="UpdateEnv[title]" placeholder="必填，建议中文，如开发环境" datatype="*" nullmsg="请输入环境名称" value="<?=$env->title?>">
            </div>

            <div class="form-group">
                <label class="control-label">环境标识</label>
                <input type="text" class="form-control js_name" name="UpdateEnv[name]" placeholder="必填，只能由数字和字母组成，如develop" datatype="/[a-z|A-Z|0-9|\-|_|\.]$/" nullmsg="请输入环境标识" errormsg="环境标识只能是数字和字母组合" value="<?=$env->name?>">
            </div>

            <div class="form-group">
                <label class="control-label">根路径</label>
                <input type="text" class="form-control js_base_url" name="UpdateEnv[base_url]" placeholder="http://或https://，如http://api.phprap.com/v1" datatype="url" nullmsg="请输入根路径" errormsg="请输入包含协议的合法路径"value="<?=$env->base_url?>">
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
