<!DOCTYPE html>
<html lang="zh-cn">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="description" content="" />
    <title>项目文档导出——<?=config('name')?></title>

    <link href="https://cdn.bootcss.com/bootstrap/3.3.1/css/bootstrap.min.css" rel="stylesheet">

    <style type="text/css">
        body {
            padding-top: 70px; margin-bottom: 15px;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
            font-family: "Roboto", "SF Pro SC", "SF Pro Display", "SF Pro Icons", "PingFang SC", BlinkMacSystemFont, -apple-system, "Segoe UI", "Microsoft Yahei", "Ubuntu", "Cantarell", "Fira Sans", "Droid Sans", "Helvetica Neue", "Helvetica", "Arial", sans-serif;
            font-weight: 400;
        }
        h2 { font-size: 1.6em; }
        hr { margin-top: 10px; }
        .panel-title>a {
            color: #23527c;
        }
        a,a:focus,a:active,a:hover {

            text-decoration:none;
        }

        .table {
            margin-bottom: 0;
            width: 100%;
            max-width: 100%;
        }
        .label { display: inline-block; min-width: 40px; padding: 0.3em 0.6em 0.3em; }
        .list-group.panel > .list-group-item {
        }
        .list-group-item:last-child {
            border-radius:0;
        }
        .panel-group .panel+.panel {
            margin-top: 10px;
        }
        h4.panel-title a {
            font-weight:normal;
            font-size:14px;
        }
        h4.panel-title a .text-muted {
            font-size:12px;
            font-weight:normal;
            font-family: 'Verdana';
        }
        #sidebar {
            width: 220px;
            position: fixed;
            margin-left: -240px;
            overflow-y:auto;
        }
        #sidebar > .list-group {
            margin-bottom:0;
        }
        #sidebar > .list-group > a{
            text-indent:0;
        }
        #sidebar .child {
            border:1px solid #ddd;
            border-bottom:none;
        }
        #sidebar .child > a {
            border:0;
        }
        #sidebar .list-group a.current {
            background:#f5f5f5;
        }
        @media (max-width: 1620px){
            #sidebar {
                margin:0;
            }
            #accordion {
                padding-left:235px;
            }
        }
        @media (max-width: 768px){
            #sidebar {
                display: none;
            }
            #accordion {
                padding-left:0px;
            }
        }

        .well {
            margin-bottom: 10px;
        }

    </style>
</head>
<body>
<!-- Fixed navbar -->
<div class="navbar navbar-default navbar-fixed-top" role="navigation">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse"> <span class="sr-only">Toggle navigation</span> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </button>
            <a class="navbar-brand" href="https://www.fastadmin.net/" target="_blank"><?=$project->title?>-接口离线文档</a>
        </div>
        <!--/.nav-collapse -->
    </div>
</div>
<div class="container">
    <!-- menu -->
    <div id="sidebar" style="max-height: 623px;">
        <div class="list-group panel">

            <a href="#项目简介" class="list-group-item current home-parent" data-toggle="collapse" data-parent="#sidebar" >项目简介 </a>
            <div class="child in" id="项目简介" style="height: auto;display: none">
                <a href="javascript:;" data-id="0" class="list-group-item home-child">-项目简介</a>
            </div>

            <?php foreach($project->modules as $module){?>
            <a href="#<?=$module->title?>" class="list-group-item collapsed" data-toggle="collapse" data-parent="#sidebar">-<?=$module->title?> </a>
            <div class="child collapse" id="<?=$module->title?>">
                <?php foreach($module->apis as $api){?>
                <a href="javascript:;" data-id="<?=$api->id?>" class="list-group-item">--<?=$api->title?></a>
                <?php }?>
            </div>
            <?php }?>

        </div>
    </div>
    <div class="panel-group" id="accordion">

        <h2>项目简介</h2>
        <hr />
        <div class="panel panel-default">
            <div class="panel-heading" id="heading-0">
                <h4 class="panel-title">项目介绍</h4>
            </div>
            <div id="collapseOne0" class="panel-collapse in" style="height: auto;">
                <div class="panel-body">

                    <p class="text-muted"><label>项目名称：</label><?=$project->title?></p>
                    <p class="text-muted"><label>项目类型：</label><?=$project->typeLabel?></p>
                    <p class="text-muted"><label>最近更新时间：</label><?=$project->updated_at?></p>
                    <p class="text-muted"><label>文档创建时间：</label><?=date('Y-m-d H:i:s')?></p>
                    <p class="text-muted"><label>项目描述：</label><span style="word-break:break-all"><?=$project->remark?></span></p>
                    <!-- Nav tabs -->

                    <!-- Tab panes -->
                    <!-- .tab-content -->
                </div>
            </div>
        </div>

        <?php foreach($project->modules as $module){?>
        <h2><?=$module->title?></h2>
        <hr />
        <?php foreach($module->apis as $api){?>
        <div class="panel panel-default">
            <div class="panel-heading" id="heading-<?=$api->id?>">
                <h4 class="panel-title"> <span class="label label-success"><?=$api->requestMethodLabel?></span> <a data-toggle="collapse" data-parent="#accordion<?=$api->id?>" href="#collapseOne<?=$api->id?>"> <?=$api->title?> <span class="text-muted"><?=$api->uri?></span></a> </h4>
            </div>
            <div id="collapseOne<?=$api->id?>" class="panel-collapse collapse">
                <div class="panel-body">
                    <!-- Nav tabs -->

                    <!-- Tab panes -->
                    <div class="tab-content">
                        <div class="tab-pane active" id="info<?=$api->id?>">
                            <div class="panel panel-default mb-0">
                                <div class="panel-heading">
                                    接口地址
                                </div>
                                <!-- /.panel-heading -->
                                <div class="panel-body">
                                    <div class="table-responsive">
                                        <table class="table">

                                            <tbody>
                                            <?php foreach($api->module->project->envs as $env){?>
                                            <tr>
                                                <td style="width: 150px;"><?=$env->title?>(<?=$env->name?>)</td>
                                                <td><code><?=$env->base_url?><?=$api->uri?></code></td>

                                            </tr>
                                            <?php }?>

                                            </tbody>
                                        </table>

                                    </div>
                                    <!-- /.table-responsive -->
                                </div>
                                <!-- /.panel-body -->
                            </div>

                            <?php if(isset($api->field->headerAttributes)){?>
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    Header参数
                                </div>
                                <!-- /.panel-heading -->
                                <div class="panel-body">
                                    <div class="table-responsive">
                                        <table class="table">
                                            <thead>
                                            <tr>
                                                <th width="200px">参数名</th>
                                                <th width="200px">参数标题</th>
                                                <th width="100px">参数类型</th>
                                                <th width="60px">必填</th>
                                                <th width="90px">参数值</th>
                                                <th>备注说明</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php foreach($api->field->headerAttributes as $header){?>
                                            <tr class="level<?=$header->level?>">
                                                <td>
                                                    <?php if($header->level){?>
                                                    <?=str_repeat('&nbsp;&nbsp;&nbsp;', $header->level)?>
                                                    <i class="fa fa-fw fa-angle-right fa-1" aria-hidden="true"></i>
                                                    <?php }?>
                                                    <?=$header->name?>
                                                </td>
                                                <td><?=$header->title?></td>

                                                <td><?=$api->field->fieldTypeLabels[$header->type]?></td>
                                                <td><?=$api->field->requiredLabels[$header->required]?></td>

                                                <td><?=$header->value?></td>
                                                <td><?=$header->remark?></td>
                                            </tr>
                                            <?php }?>

                                            </tbody>
                                        </table>
                                    </div>
                                    <!-- /.table-responsive -->
                                </div>
                                <!-- /.panel-body -->
                            </div>
                            <?php }?>

                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    请求参数
                                </div>
                                <!-- /.panel-heading -->
                                <div class="panel-body">
                                    <div class="table-responsive">
                                        <table class="table">
                                            <thead>
                                            <tr>
                                                <th width="200px">参数名</th>
                                                <th width="200px">参数标题</th>
                                                <th width="100px">参数类型</th>
                                                <th width="60px">必填</th>
                                                <th width="90px">示例值</th>
                                                <th>备注说明</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php foreach($api->field->requestAttributes as $request){?>
                                            <tr class="level<?=$request->level?>">
                                                <td>
                                                    <?php if($request->level){?>
                                                    <?=str_repeat('&nbsp;&nbsp;&nbsp;', $request->level)?>
                                                    <i class="fa fa-fw fa-angle-right fa-1" aria-hidden="true"></i>
                                                    <?php }?>
                                                    <?=$request->name?>
                                                </td>

                                                <td><?=$request->title?></td>
                                                <td><?=$api->field->fieldTypeLabels[$request->type]?></td>
                                                <td><?=$api->field->requiredLabels[$request->required]?></td>
                                                <td><?=$request->example_value?></td>
                                                <td><?=$request->remark?></td>
                                            </tr>
                                            <?php }?>
                                            </tbody>
                                        </table>
                                    </div>
                                    <!-- /.table-responsive -->
                                </div>
                                <!-- /.panel-body -->
                            </div>

                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    请求示例
                                </div>

                                <div class="panel-body json-view-request-hidden" style="display: none;">
                                    <?=$api->field->requestJson?>
                                </div>
                                <div class="panel-body json-view-request-show">
                                </div>
                            </div>

                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    响应参数
                                </div>
                                <!-- /.panel-heading -->
                                <div class="panel-body">
                                    <div class="table-responsive">
                                        <table class="table">
                                            <thead>
                                            <tr>
                                                <th width="200px">参数名</th>
                                                <th width="200px">参数标题</th>
                                                <th width="100px">参数类型</th>
                                                <th width="150px">示例值</th>
                                                <th>备注说明</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php foreach($api->field->responseAttributes as $response){?>
                                            <tr class="level<?=$response->level?>">
                                                <td>
                                                    <?php if($response->level){?>
                                                    <?=str_repeat('&nbsp;&nbsp;&nbsp;', $response->level)?>
                                                    <i class="fa fa-fw fa-angle-right fa-1" aria-hidden="true"></i>
                                                    <?php }?>
                                                    <?=$response->name?>
                                                </td>
                                                <td><?=$response->title?></td>
                                                <td><?=$api->field->fieldTypeLabels[$response->type]?></td>
                                                <td><?=$response->example_value?></td>
                                                <td><?=$response->remark?></td>
                                            </tr>
                                            <?php }?>
                                            </tbody>
                                        </table>
                                    </div>
                                    <!-- /.table-responsive -->
                                </div>


                                <!-- /.panel-body -->
                            </div>

                        </div>

                        <div class="panel panel-default">
                            <div class="panel-heading">
                                响应示例
                            </div>

                            <div class="panel-body json-view-response-hidden" style="display: none;">
                                <?=$api->field->responseJson?>
                            </div>
                            <div class="panel-body json-view-response-show">
                            </div>
                        </div>
                        <!-- #info -->
                        <!-- #sandbox -->
                        <!-- #sample -->
                    </div>
                    <!-- .tab-content -->
                </div>
            </div>
        </div>
        <?php }?>
        <?php }?>
    </div>
    <hr />

    <p class="text-center"><?=config('app.copyright')?> Build By <a target="_blank" href="http://www.phprap.com/">PHPRAP</a></p>

</div>
<!-- /container -->
<script src="https://cdn.staticfile.org/jquery/2.1.0-rc1/jquery.min.js"></script>
<script src="https://cdn.staticfile.org/twitter-bootstrap/3.3.1/js/bootstrap.min.js"></script>
<link href="https://cdn.bootcss.com/jquery-jsonview/1.2.3/jquery.jsonview.min.css" rel="stylesheet">
<script src="https://cdn.bootcss.com/jquery-jsonview/1.2.3/jquery.jsonview.min.js"></script>
<style>
    .collapser{
        display:none;
    }
    .jsonview .q{
        width: auto;
        color: #0b7500;
    }
</style>
<script type="text/javascript">


    function prepareStr(str) {
        try {
            return syntaxHighlight(JSON.stringify(JSON.parse(str.replace(/'/g, '"')), null, 2));
        } catch (e) {
            return str;
        }
    }

    $(function () {

        $(".json-view-response-hidden").each(function () {
            var val = $(this).html().trim();
            var options = {
                collapsed: false,
                nl2br: false,
                recursive_collapser: false,
                escape: false,
                withQuotes: true
            };
            if(val != ""){

                $('.json-view-response-show').JSONView(JSON.parse(val),options);
            }
        });
        $(".json-view-request-hidden").each(function () {
            var val = $(this).html().trim();
            var options = {
                collapsed: false,
                nl2br: false,
                recursive_collapser: false,
                escape: false,
                withQuotes: true
            };
            if(val != ""){

                $('.json-view-request-show').JSONView(JSON.parse(val),options);
            }
        });
        $(".home-parent").on('click',function () {
            $(".home-child").trigger('click');
        });

        $('[data-toggle="tooltip"]').tooltip({
            placement: 'bottom'
        });

        $(window).on("resize", function(){
            $("#sidebar").css("max-height", $(window).height()-80);
        });

        $(window).trigger("resize");

        $(document).on("click", "#sidebar .list-group > .list-group-item", function(){
            $("#sidebar .list-group > .list-group-item").removeClass("current");
            $(this).addClass("current");
        });
        $(document).on("click", "#sidebar .child a", function(){
            var heading = $("#heading-"+$(this).data("id"));
            if(!heading.next().hasClass("in")){
                $("a", heading).trigger("click");
            }
            $("html,body").animate({scrollTop:heading.offset().top-70});
        });

        $('code[id^=response]').hide();

        $.each($('pre[id^=sample_response],pre[id^=sample_post_body]'), function () {
            if ($(this).html() == 'NA') {
                return;
            }
            var str = prepareStr($(this).html());
            $(this).html(str);
        });

        $("[data-toggle=popover]").popover({placement: 'right'});

    });
</script>
</body>
</html>