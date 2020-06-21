<?php include_view(['name'=>'home/public/header','title'=>'接口管理'])?>
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
                <label>所属模块</label>

                <select name="UpdateApi[module_id]" class="form-control">
                    <?php foreach($api->project->modules as $k => $v){?>
                    <option value="<?=$v->encode_id?>" <?php if($api->module->id == $v->id){?>selected<?php }?>><?=$v->title?></option>
                    <?php }?>
                </select>

            </div>

            <div class="form-group">
                <label>接口名称</label>
                <input class="form-control" name="UpdateApi[title]" value="<?=$api->title?>" placeholder="必填" datatype="*" nullmsg="请输入接口名称">
            </div>

            <div class="form-group">
                <label class="control-label">请求方式</label>
                <div class="form-group">
                    <?php foreach($api->requestMethodLabels as $k => $v){?>
                    <label class="radio-inline">
                        <?php if(!$api->id){?>
                        <input type="radio" name="UpdateApi[request_method]" <?php if($k == 'post'){?>checked<?php }?> value="<?=$k?>"> <?=$v?>
                        <?=else?>
                        <input type="radio" name="UpdateApi[request_method]" <?php if($k == $api->request_method){?>checked<?php }?> value="<?=$k?>"> <?=$v?>
                        <?php }?>
                    </label>
                    <?php }?>
                </div>
            </div>

            <div class="form-group">
                <label class="control-label">响应格式</label>
                <div class="form-group">
                    <?php foreach($api->responseFormatLabels as $k => $v){?>
                    <label class="radio-inline">
                        <input type="radio" name="UpdateApi[response_format]" <?php if($k == $api->response_format){?>checked<?php }?> value="<?=$k?>"> <?=$v?>
                    </label>
                    <?php }?>
                </div>
            </div>

            <div class="form-group">
                <label>接口路径</label>
                <input class="form-control" name="UpdateApi[uri]" value="<?=$api->uri?>" placeholder="非必填，不包含域名部分，如/user/getUsers.json" ignore="ignore" datatype="*1-250">
            </div>

            <div class="form-group">
                <label class="control-label">接口描述</label>
                <textarea class="form-control js_remark" name="UpdateApi[remark]" placeholder="非必填，可以写接口加密规则等" ignore='ignore' datatype="*1-250" nullmsg="请输入模块描述"><?=$api->remark?></textarea>
            </div>

            <div class="form-group">
                <label class="control-label">接口排序
                    <a data-toggle="tooltip" data-placement="right" title="排序数字越大越靠前，相同数字越先创建越靠前" class="btn-show-tips">
                        <i class="fa fa-info-circle"></i>
                    </a>
                </label>
                <input type="text" class="form-control js_sort" name="UpdateApi[sort]" value="<?=$api->sort|default:0?>" placeholder="排序数字越大越靠前" datatype="n" nullmsg="请输入排序数字" errormsg="必须是数字">
            </div>


            <div class="form-group">
                <label class="control-label">自动解析response<a data-toggle="tooltip" data-placement="right" class="btn-show-tips" data-title="开启后会在接口自动解析结果集到响应字段">
                    <i class="fa fa-info-circle"></i>
                </a></label>
                <div class="form-group">
                    <label class="radio-inline">
                        <input type="radio" name="UpdateApi[response_auto_parse]"  <?php if($api->response_auto_parse == 1){?>checked<?php }?>  value=1 > 开启
                    </label>
                    <label class="radio-inline">
                        <input type="radio" name="UpdateApi[response_auto_parse]" <?php if($api->response_auto_parse == 0){?>checked<?php }?> value=0> 关闭
                    </label>
                </div>
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
