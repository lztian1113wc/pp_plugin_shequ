<?php
/**
 * Created by PhpStorm.
 * User: wangchuan
 * Date: 2018/5/24
 * Time: 12:50
 */
global $zbp;
require ZBP_PATH . 'zb_users/plugin/pp_plugin_shequ/html/header.php';
?>

<div class="layui-container fly-marginTop fly-user-main">
    <ul class="layui-nav layui-nav-tree layui-inline" lay-filter="user">
        <li class="layui-nav-item">
            <a href="/shequ/user/home.html">
                <i class="layui-icon">&#xe609;</i>
                我的主页
            </a>
        </li>
        <li class="layui-nav-item">
            <a href="/shequ/user/index.html">
                <i class="layui-icon">&#xe612;</i>
                用户中心
            </a>
        </li>
        <li class="layui-nav-item">
            <a href="/shequ/user/set.html">
                <i class="layui-icon">&#xe620;</i>
                基本设置
            </a>
        </li>
        <li class="layui-nav-item layui-this">
            <a href="/shequ/user/message.html">
                <i class="layui-icon">&#xe611;</i>
                我的消息
                <?php if($pp_plugin_shequ_detail_comment_count>0){?><span class="layui-badge"><?php echo $pp_plugin_shequ_detail_comment_count;?></span><?php };?>
            </a>
        </li>

        <li class="layui-nav-item">
            <a href="/shequ/user/zhanghu.html">
                <i class="layui-icon">&#xe66c;</i>
                我的账户
            </a>
        </li>
        <?php if($zbp->CheckRights('root')){?>
            <li class="layui-nav-item">
                <a href="/shequ/user/shop.html">
                    <i class="layui-icon">&#xe698;</i>
                    我的商店
                </a>
            </li>
        <?php };?>
    </ul>

    <div class="site-tree-mobile layui-hide">
        <i class="layui-icon">&#xe602;</i>
    </div>
    <div class="site-mobile-shade"></div>

    <div class="site-tree-mobile layui-hide">
        <i class="layui-icon">&#xe602;</i>
    </div>
    <div class="site-mobile-shade"></div>

    <?php
    $pp_plugin_shequ_post_arr = $zbp->db->query($zbp->db->sql->Select(
        'pp_plugin_shequ_message'
        , '*'
        , 'mess_touserid='.$zbp->user->ID
        , 'mess_ID asc'
        , ''
        , ''
    ));
    ?>
    <div class="fly-panel fly-panel-user" pad20>
        <div class="layui-tab layui-tab-brief" lay-filter="user" id="LAY_msg" style="margin-top: 15px;">
            <?php if(count($pp_plugin_shequ_post_arr)>0){?>
                <button class="layui-btn layui-btn-danger" id="LAY_delallmsg">清空全部消息</button>
            <?php };?>
            <div  id="LAY_minemsg" style="margin-top: 10px;">
                <?php if(count($pp_plugin_shequ_post_arr)==0){?>
                <div class="fly-none">您暂时没有最新消息</div>
                <?php };?>

                <ul class="mine-msg">
                    <?php foreach ($pp_plugin_shequ_post_arr as $post=>$value) {?>
                    <li>
                        <blockquote class="layui-elem-quote">
                            <?php echo str_replace('{#ZC_BLOG_HOST#}','',$value["mess_Content"]);?>
                        </blockquote>
                        <p><span><?php echo pp_plugin_shequ_wordTime($value["mess_PostTime"]);?></span>
                            <a href="javascript:;" name="L_delete" lay-id="<?php echo $value["mess_ID"];?>" class="layui-btn layui-btn-small layui-btn-danger fly-delete">删除</a></p>
                    </li>
                    <?php };?>
                </ul>
            </div>
        </div>
    </div>

</div>
<?php require ZBP_PATH . 'zb_users/plugin/pp_plugin_shequ/html/footer.php'; ?>
<script>
    layui.use(['form'],function(){
        $("#LAY_delallmsg").on("click",function(){
            var loadIndex = layer.load();
            var url = '<?php echo $zbp->host;?>zb_users/plugin/pp_plugin_shequ/html/user/cmd.php?act=messageDelAll';
            $.post(url,{},function(res){
                if (res==1) {
                    layer.alert("已删除",function(){
                        layer.close(loadIndex);
                        window.location.reload();
                    })
                }else{
                    layer.close(loadIndex);
                    layer.msg('网络错误',function(){});
                    return false;
                }
            })
        })
        $("a[name=L_delete]").on("click",function(){
            var loadIndex = layer.load();
            var lay_id=$(this).attr("lay-id");
            var url = '<?php echo $zbp->host;?>zb_users/plugin/pp_plugin_shequ/html/user/cmd.php?act=messageDel';
            $.post(url,{mid:lay_id},function(res){
                if (res==1) {
                    layer.alert("已删除",function(){
                        layer.close(loadIndex);
                        window.location.reload();
                    })
                }else{
                    layer.close(loadIndex);
                    layer.msg('网络错误',function(){});
                    return false;
                }
            })
        })
        return false;
    })
</script>
