
<ul class="nav nav-tabs">
    <li class="<?php if($tab == 'home'){?>active<?php }?>"><a href="<?=url('home/project/show', ['id' => $project->encode_id, 'tab' => 'home'])?>">项目主页</a></li>

    <?php if($project->hasAuth(['env' => 'look'])){?>
    <li class="<?php if($tab == 'env'){?>active<?php }?>"><a href="<?=url('home/project/show', ['id' => $project->encode_id, 'tab' => 'env'])?>">项目环境</a></li>
    <?php }?>

    <?php if($project->hasAuth(['template' => 'look'])){?>
    <li class="<?php if($tab == 'template'){?>active<?php }?>"><a href="<?=url('home/project/show', ['id' => $project->encode_id, 'tab' => 'template'])?>">项目模板</a></li>
    <?php }?>
    
    <?php if($project->hasAuth(['member' => 'look'])){?>
    <li class="<?php if($tab == 'member'){?>active<?php }?>"><a href="<?=url('home/project/show', ['id' => $project->encode_id, 'tab' => 'member'])?>">项目成员</a></li>
    <?php }?>

    <?php if($project->hasAuth(['project' => 'history'])){?>
    <li class="hidden-xs <?php if($tab == 'history'){?>active<?php }?>"><a href="<?=url('home/project/show', ['id' => $project->encode_id, 'tab' => 'history'])?>">项目动态</a></li>
    <?php }?>
</ul>