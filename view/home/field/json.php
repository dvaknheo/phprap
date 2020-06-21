<?php include_view(['name'=>'home/public/header','title'=>'编辑JSON'])?>
<style>
    .table>thead>tr>th, .table>tbody>tr>th, .table>tfoot>tr>th, .table>thead>tr>td, .table>tbody>tr>td, .table>tfoot>tr>td {
        padding: 8px 8px 8px 0;
        line-height: 1.42857143;
        vertical-align: top;
        border-top: 1px solid #ddd;
    }
</style>
</head>

<body>

<div id="wrapper">

    <!-- Navigation -->
    <?php include_view(['name'=>'home/public/nav','sidebar'=>'home/project/sidebar'])?>
    <div id="page-wrapper">

        <form role="form" action="<?=url()?>" method="post">

            <input type="hidden" name="csrf-phprap" value="<?=csrf_token()?>" />

            <div class="row">
                <div class="col-lg-12">
                    <div class="page-header">
                        <h1>导入字段</h1>
                        <div class="opt-btn">
                            <!--<a class="btn btn-sm btn-success js_submit" href="javascript:void(0);"><i class="fa fa-fw fa-save"></i>导入</a>-->
                            <a class="btn btn-sm btn-warning js_cancel" href="javascript:;" onclick="cancelSave()"><i class="fa fa-fw fa-reply"></i>取消</a>
                            <a class="btn btn-sm btn-success ml-1" id="js_submit" href="javascript:void(0);"><i class="fa fa-fw fa-save"></i>保存</a>

                        </div>
                    </div>
                </div>
            </div>

            <div class="alert alert-dismissable alert-warning">
                <i class="fa fa-fw fa-info-circle"></i>&nbsp;
                请从其他接口复制JSON导入，导入后会覆盖已有的字段，请慎重操作！
            </div>

            <div class="row">

                <div class="col-lg-12">

                    <div class="panel panel-default">

                        <?php include_view(['name'=>'home/api/tab','tab'=>'field'])?>

                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                            Header参数
                                        </div>

                                        <!-- /.panel-heading -->
                                        <div class="panel-body">
                                            <div class="table-responsive">
                                                <textarea name="UpdateField[header_fields]" placeholder="JSON格式" class="form-control js_header_fields" rows="5"><?=$field->header_fields?></textarea>
                                            </div>
                                            <!-- /.table-responsive -->
                                        </div>
                                        <!-- /.panel-body -->
                                    </div>
                                    <!-- /.panel -->
                                </div>
                                <!-- /.col-lg-6 -->
                            </div>

                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                            请求参数
                                        </div>
                                        <!-- /.panel-heading -->
                                        <div class="panel-body">
                                            <div class="table-responsive">
                                                <textarea name="UpdateField[request_fields]" placeholder="JSON格式" class="form-control js_request_fields" rows="5"><?=$field->request_fields?></textarea>
                                            </div>
                                            <!-- /.table-responsive -->
                                        </div>
                                        <!-- /.panel-body -->
                                    </div>
                                    <!-- /.panel -->
                                </div>
                                <!-- /.col-lg-6 -->
                            </div>

                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="panel panel-default mb-0">
                                        <div class="panel-heading">
                                            响应参数
                                        </div>
                                        <!-- /.panel-heading -->
                                        <div class="panel-body">
                                            <div class="table-responsive">
                                                <textarea name="UpdateField[response_fields]" placeholder="JSON格式" class="form-control js_response_fields" rows="5"><?=$field->response_fields?></textarea>
                                            </div>
                                            <!-- /.table-responsive -->
                                        </div>
                                        <!-- /.panel-body -->
                                    </div>
                                    <!-- /.panel -->
                                </div>
                                <!-- /.col-lg-6 -->
                            </div>

                        </div>

                        <!-- /.panel-body -->
                    </div>

                </div>

            </div>
        </form>

    </div>

    <!-- /#page-wrapper -->

</div>

<!-- /#wrapper -->
<?php include_view(['name'=>'home/public/copyright'])?>

<script>
    // 取消保存
    function cancelSave() {
        confirm('您编辑的内容还没有保存，确定要退出吗？', function () {
            window.location.href = "<?=url('home/api/show', ['id' => $field->api->encode_id, 'tab' => 'field'])?>";
        });
    }

    $(function(){
        // 表单验证
        $("form").validateForm({
            'success':function (json) {
                window.location.href = json.callback;
            },
        });
    });

</script>
<?php include_view(['name'=>'home/public/footer'])?>