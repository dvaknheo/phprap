<?php include_view(['name'=>'home/public/header','title'=>'个人主页'])?>

</head>

<body>

<div id="wrapper">

    <!-- Navigation -->
    <?php include_view(['name'=>'home/public/nav','sidebar'=>'home/account/sidebar','active'=>'account'])?>
    <div id="page-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <div class="page-header">
                    <h1>个人主页 </h1>
                    <div class="opt-btn">

                        <a href="javascript:void(0);" class="btn hidden-xs btn-sm btn-success" data-toggle="tooltip" data-placement="bottom" data-modal="#js_popModal" data-title="编辑资料" data-height="210" data-src="<?=url('home/account/profile')?>"><i class="fa fa-fw fa-edit"></i>编辑</a>

                    </div>
                </div>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <!-- /.row -->
        <?php if($account->lastLogin->id){?>
        <div class="alert alert-warning fade in m-b-15">
            <strong>温馨提示!</strong>
            您上次登录时间 <?=$account->lastLogin->created_at?>，登录地点<?=$account->lastLogin->location?> ，浏览器 <?=$account->lastLogin->browser?>，更多登录历史请点击<a href="<?=url('home/history/login')?>?user_id=<?=$user.id?>">这里</a>。
            <span class="close" data-dismiss="alert">×</span>
        </div>
        <?php }?>
        <div class="row">

            <div class="col-lg-12">

                <div class="panel panel-default">

                    <div class="panel-body">

                        <p class="text-muted"><label>登录账号：</label><?=$account->email?></p>
                        <p class="text-muted"><label>用户昵称：</label><?=$account->name?></p>
                        <p class="text-muted"><label>注册时间：</label><?=$account->created_at?></p>
                        <p class="text-muted"><label>注册IP：</label><?=$account->ip?></p>
                        <p class="text-muted"><label>注册地点：</label><?=$account->location?></p>
                        <p class="text-muted"><label>创建项目数：</label><?=$account->getCreatedProjectsCount()?></p>
                        <p class="text-muted"><label>参数项目数：</label><?=$account->getJoinedProjectsCount()?></p>

                    </div>
                    <!-- /.panel-body -->
                </div>
                <!-- /.panel -->
            </div>
            <!-- /.col-lg-12 -->
        </div>

        <div class="row">
            <div class="col-lg-6">

                <!-- /.panel -->
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <i class="fa fa-bar-chart-o fa-fw"></i> 我创建的项目
                    </div>
                    <!-- /.panel-heading -->
                    <div class="panel-body">
                        <div id="project1-chart" style="width: 100%;height:400px;"></div>
                    </div>
                    <!-- /.panel-body -->
                </div>
                <!-- /.panel -->
            </div>
            <div class="col-lg-6">

                <!-- /.panel -->
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <i class="fa fa-bar-chart-o fa-fw"></i> 我参与的项目
                    </div>
                    <!-- /.panel-heading -->
                    <div class="panel-body">
                        <div id="project2-chart" style="width: 100%;height:400px;"></div>
                    </div>
                    <!-- /.panel-body -->
                </div>
                <!-- /.panel -->
            </div>
            <!-- /.col-lg-8 -->

            <!-- /.col-lg-4 -->
        </div>

    </div>
    <!-- /#page-wrapper -->

</div>
<!-- /#wrapper -->
<?php include_view(['name'=>'home/public/copyright'])?>

<script src="<?=STATIC_URL?>/plugins/bootstrap/js/echarts.min.js?v=1.0"></script>

<script type="text/javascript">

    // 基于准备好的dom，初始化echarts实例
    var myChart = echarts.init(document.getElementById('project1-chart'));

    // 指定图表的配置项和数据
    var option = {
        tooltip : {
            trigger: 'item',
            // formatter: "{a} <br/>{b} : {c} ({d}%)"
        },
        legend: {
            orient: 'vertical',
            left: 'left',
            data: ['公开项目','私有项目']
        },
        series : [
            {
                name: '项目数量',
                type: 'pie',
                radius : '55%',
                center: ['50%', '60%'],
                data:[
                    {value:<?=$account->getCreatedProjects(10)->count()?>, name:'公开项目'},
                    {value:<?=$account->getCreatedProjects(30)->count()?>, name:'私有项目'},
                ],
                itemStyle: {
                    emphasis: {
                        shadowBlur: 10,
                        shadowOffsetX: 0,
                        shadowColor: 'rgba(0, 0, 0, 0.5)'
                    }
                }
            }
        ]
    };

    // 使用刚指定的配置项和数据显示图表。
    myChart.setOption(option);

    // 基于准备好的dom，初始化echarts实例
    var myChart = echarts.init(document.getElementById('project2-chart'));

    // 指定图表的配置项和数据
    var option = {

        tooltip : {
            trigger: 'item',
            // formatter: "{a} <br/>{b} : {c} ({d}%)"
        },
        legend: {
            orient: 'vertical',
            left: 'left',
            data: ['公开项目','私有项目']
        },
        series : [
            {
                name: '项目数量',
                type: 'pie',
                radius : '55%',
                center: ['50%', '60%'],
                data:[
                    {value:<?=$account->getJoinedProjects(10)->count()?>, name:'公开项目'},
                    {value:<?=$account->getJoinedProjects(30)->count()?>, name:'私有项目'},
                ],
                itemStyle: {
                    emphasis: {
                        shadowBlur: 10,
                        shadowOffsetX: 0,
                        shadowColor: 'rgba(0, 0, 0, 0.5)'
                    }
                }
            }
        ]
    };

    // 使用刚指定的配置项和数据显示图表。
    myChart.setOption(option);
</script>

<?php include_view(['name'=>'home/public/footer'])?>