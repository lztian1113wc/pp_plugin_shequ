<?php
/**
 * Created by PhpStorm.
 * User: wangchuan
 * Date: 2018/5/21
 * Time: 11:26
 */
?>
<div class="fly-panel fly-column">
    <div class="layui-container">
        <ul class="layui-clear">
            <?php
            $pp_plugin_shequ_fenlei_arr = $zbp->GetListType('Category'
                ,$zbp->db->sql->Select($zbp->table['Category'], '*', '', '', '', ''));
            ?>
            <li class="layui-hide-xs <?php if(count($url_parm_arr)==2 || $url_parm_arr[2]=='index'){echo 'layui-this';}?>"><a href="/shequ/index.html">首页</a></li>
            <?php foreach($pp_plugin_shequ_fenlei_arr as $fenlei){?>
                <li class="<?php if($url_parm_arr[2]=='category' && $url_parm_arr[3]==$fenlei->ID){echo 'layui-this';}?>"><a href="/shequ/category/<?php echo $fenlei->ID;?>.html"><?php echo $fenlei->Name;?></a></li>
            <?php } ?>
            <!-- 用户登入后显示 -->
            <?php if(!empty($zbp->user->ID)) {?>
                <li class="layui-hide-xs layui-hide-sm layui-show-md-inline-block"><a href="/shequ/user/index.html">我发表的贴</a></li>
                <li class="layui-hide-xs layui-hide-sm layui-show-md-inline-block"><a href="/shequ/user/index.html#tab=collection">我收藏的贴</a></li>
            <?php } ;?>
        </ul>

        <div class="fly-column-right layui-hide-xs">

            <?php if(!empty($zbp->user->ID)) {?>
                <!--            <span class="fly-search"><i class="layui-icon"></i></span>-->
                <a href="/shequ/article/add.html" class="layui-btn">发表新帖</a>
            <?php }; ?>
        </div>


    </div>
</div>
