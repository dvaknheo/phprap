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

            <div class="form-group">
                <label class="control-label">模块名称</label>
                <input type="text" class="form-control js_title" name="UpdateModule[title]" value="<?=$module->title?>" placeholder="必填" datatype="*1-50" nullmsg="请输入模块名称" errormsg="模块名称不能超过50个字符">
            </div>

            <div class="form-group">
                <label class="control-label">模块描述</label>
                <textarea class="form-control js_remark" name="UpdateModule[remark]" placeholder="非必填" ignore="ignore" datatype="*1-250" nullmsg="请输入模块描述"><?=$module->remark?></textarea>
            </div>

            <div class="form-group">
                <label class="control-label">模块排序
                    <a data-toggle="tooltip" data-placement="right" title="排序数字越大越靠前，相同数字越先创建越靠前" class="btn-show-tips">
                        <i class="fa fa-info-circle"></i>
                    </a>
                </label>
                <input type="text" class="form-control js_sort" name="UpdateModule[sort]" value="<?=$module->sort|default:0?>" placeholder="排序数字越大越靠前" datatype="n" nullmsg="请输入排序数字" errormsg="必须是数字">
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
