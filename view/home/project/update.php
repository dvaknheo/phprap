<?php include_view(['name'=>'home/public/header','title'=>'项目管理'])?>
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

        <form role="form" action="<?=url('')?>" method="post">

            <input type="hidden" name="csrf-phprap" value="<?=csrf_token()?>" />

            <div class="form-group">
                <label class="control-label">项目名称</label>
                <input type="text" class="form-control js_title" name="UpdateProject[title]" value="<?=$project->title?>" placeholder="必填，建议50个字符以内" datatype="*" nullmsg="请输入项目名称" errormsg="请输入项目名称">
            </div>

            <div class="form-group">
                <label class="control-label">项目描述</label>
                <textarea class="form-control" name="UpdateProject[remark]" rows="3" placeholder="必填，250个字符以内" datatype="*1-250" nullmsg="请输入项目描述"><?=$project->remark?></textarea>
            </div>

            <div class="form-group">
                <label>项目类型</label>
                <div class="radio">
                    <label>
                        <input type="radio" name="UpdateProject[type]" value="<?=$project::PUBLIC_TYPE?>" <?php if($project->type == $project::PUBLIC_TYPE){?>checked<?php }?>>公开项目(无需登录即可查看且只能查看，可以被搜索到)
                    </label>
                </div>
                <div class="radio">
                    <label>
                        <input type="radio" name="UpdateProject[type]" value="<?=$project::PRIVATE_TYPE?>" <?php if($project->type == $project::PRIVATE_TYPE){?>checked<?php }?>>私有项目(只有该项目成员才可以查看，无法被搜索到)
                    </label>
                </div>
            </div>

            <div class="form-group">
                <label class="control-label">项目排序
                    <a data-toggle="tooltip" data-placement="right" title="排序数字越大越靠前，相同数字先创建的靠前" class="btn-show-tips">
                        <i class="fa fa-info-circle"></i>
                    </a>
                </label>
                <input type="text" class="form-control js_sort" name="UpdateProject[sort]" value="<?=$project->sort|default:0?>" placeholder="排序数字越大越靠前" datatype="n" nullmsg="请输入排序数字" errormsg="必须是数字">
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
