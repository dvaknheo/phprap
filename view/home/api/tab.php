
<ul class="nav nav-tabs">
    <li class="<?php if($tab == 'home'){?>active<?php }?>"><a href="<?=url('home/api/show', ['id' => $api->encode_id, 'tab' => 'home'])?>">接口主页</a></li>
    <li class="<?php if($tab == 'field'){?>active<?php }?>"><a href="<?=url('home/api/show', ['id' => $api->encode_id, 'tab' => 'field'])?>">接口字段</a></li>
    <?php if($project->hasAuth(['api' => 'debug'])){?>
    <li class="hidden-xs <?php if($tab == 'debug'){?>active<?php }?>"><a href="<?=url('home/api/show', ['id' => $api->encode_id, 'tab' => 'debug'])?>">接口调试</a></li>
    <?php }?>
    <?php if($project->hasAuth(['api' => 'history'])){?>
    <li class="hidden-xs <?php if($tab == 'history'){?>active<?php }?>"><a href="<?=url('home/api/show', ['id' => $api->encode_id, 'tab' => 'history'])?>">接口动态</a></li>
    <?php }?>
</ul>