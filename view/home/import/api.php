<?php include_view(['name'=>'home/public/header','title'=>'模块管理'])?>
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
                请输入从导出备份数据里复制的json数据
            </div>

            <div class="form-group">
                <textarea class="form-control js_remark" name="UpdateModule[remark]" placeholder="非必填" datatype="*1-250" nullmsg="请输入模块描述"><?=$module->remark?></textarea>
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
        'success':function (json) {
            parent.location.reload();
        },
    });
});

</script>

<?php include_view(['name'=>'home/public/footer'])?>
