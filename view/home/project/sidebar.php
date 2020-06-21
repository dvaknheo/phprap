<div class="navbar-default sidebar" role="navigation">
    <div class="sidebar-nav navbar-collapse">

        <ul class="nav" id="sidebar-menu">
            <li>
                <a href="<?=url('home/project/show', ['id' => $project->encode_id])?>"><i class="fa fa-home fa-fw"></i> 项目主页</a>
            </li>
            <?php foreach($project->modules as $module){?>
            <li class="module-item <?php if($module->id == $api->module->id){?>active<?php }?>">
                <a href="javascript:void(0);" aria-expanded="false">
                    <i class="fa fa-fw arrow"></i>
                    <i class="fa fa-fw fa-folder-open"></i>
                    <?=$module->title?>

                    <?php if($project->hasAuth(['api' => 'create'])){?>
                    <i class="fa hidden-xs fa-fw fa-plus option-btn pull-right mt-0" data-toggle="tooltip" data-placement="bottom" data-modal="#js_popModal" data-title="添加接口" data-height="600" data-src="<?=url('home/api/create', ['module_id' => $module->encode_id])?>"></i>
                    <?php }?>

                    <?php if($project->hasAuth(['module' => 'delete'])){?>
                    <i class="fa hidden-xs fa-fw fa-trash-o option-btn pull-right mt-0" data-toggle="tooltip" data-placement="bottom" data-modal="#js_popModal" data-title="删除模块" data-height="250" data-src="<?=url('home/module/delete', ['id' => $module->encode_id])?>"></i>
                    <?php }?>

                    <?php if($project->hasAuth(['module' => 'update'])){?>
                    <i class="fa hidden-xs fa-fw fa-pencil option-btn pull-right mt-0" data-toggle="tooltip" data-placement="bottom" data-modal="#js_popModal" data-title="编辑模块" data-height="230" data-src="<?=url('home/module/update', ['id' => $module->encode_id])?>"></i>
                    <?php }?>
                </a>
                <ul class="nav nav-second-level collapse <?php if($module->id == $api->module->id){?>in<?php }?>" aria-expanded="true">
                    <?php foreach($module->apis as $k => $v){?>
                    <li class="api-item">
                        <a class="<?php if($api->id == $v->id){?>active<?php }?>" href="<?=url('home/api/show', ['id' => $v->encode_id])?>" title="点击查看接口详情">
                            <i class="fa fa-fw fa-files-o"></i><?=$v->title?>

                            <?php if($project->hasAuth(['api' => 'delete'])){?>
                            <i class="fa hidden-xs fa-fw fa-trash-o option-btn pull-right mt-1" data-toggle="tooltip" data-placement="bottom" data-modal="#js_popModal" data-title="删除接口" data-height="230" data-src="<?=url('home/api/delete', ['id' => $v->encode_id])?>"></i>
                            <?php }?>

                            <?php if($project->hasAuth(['api' => 'update'])){?>
                            <i class="fa hidden-xs fa-fw fa-pencil option-btn pull-right mt-1" data-toggle="tooltip" data-placement="bottom" data-modal="#js_popModal" data-title="编辑接口" data-height="600" data-src="<?=url('home/api/update', ['id' => $v->encode_id])?>"></i>
                            <?php }?>

                        </a>
                    </li>
                    <?php }?>
                </ul>
            </li>
            <?php }?>

            <?php if($project->hasAuth(['module' => 'create'])){?>
            <li>
                <a class="hidden-xs" data-modal="#js_popModal" data-height="230" data-title="添加模块" data-src="<?=url('home/module/create', ['project_id' => $project->encode_id])?>" href="javascript:void(0);"><i class="fa fa-fw fa-plus"></i> 添加模块</a>
            </li>
            <?php }?>

        </ul>
    </div>
    <!-- /.sidebar-collapse -->
</div>
