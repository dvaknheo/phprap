<div class="navbar-default sidebar" role="navigation">
    <div class="sidebar-nav navbar-collapse">

        <ul class="nav" id="side-menu">

            <li>
                <a href="<?=url('admin/home/index')?>" <?php if($active == 'home'){?>class="active"<?php }?>><i class="fa fa-home fa-fw"></i> 管理主页</a>
            </li>

            <li>
                <a href="<?=url('admin/project/index')?>" <?php if($active == 'project'){?>class="active"<?php }?>><i class="fa fa-folder-open fa-fw"></i> 项目管理</a>
            </li>
            <li>
                <a href="<?=url('admin/user/index')?>" <?php if($active == 'user'){?>class="active"<?php }?>><i class="fa fa-user fa-fw"></i> 用户管理</a>
            </li>

            <li>
                <a href="<?=url('admin/history/login')?>" <?php if($active == 'history'){?>class="active"<?php }?>><i class="fa fa-history fa-fw"></i> 登录历史</a>
            </li>

            <li>
                <a href="<?=url('admin/setting/app')?>" <?php if($active == 'config'){?>class="active"<?php }?>><i class="fa fa-gear fa-fw"></i> 设置管理</a>
            </li>

        </ul>
    </div>
    <!-- /.sidebar-collapse -->
</div>