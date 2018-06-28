<?php
/**
 * Created by PhpStorm.
 * User: wangchuan
 * Date: 2018/5/15
 * Time: 15:53
 */

global $zbp;

require ZBP_PATH . 'zb_users/plugin/pp_plugin_shequ/html/header.php';
require ZBP_PATH . 'zb_users/plugin/pp_plugin_shequ/html/toolbar.php';

?>
<div class="layui-container">
    <div class="layui-row layui-col-space15">
        <div class="layui-col-md8">
            <div class="fly-panel">
                <div class="fly-panel-title fly-filter">
                    <a>置顶</a>
                    <a href="#signin" class="layui-hide-sm layui-show-xs-block fly-right" id="LAY_goSignin" style="color: #FF5722;">去签到</a>
                </div>
                <ul class="fly-list">
                <?php
                $pp_plugin_shequ_post_arr = $zbp->db->query($zbp->db->sql->Select(
                    $zbp->table['Post'].' b left JOIN pp_plugin_shequ_post a ON b.log_ID=a.p_postid LEFT JOIN '.$zbp->table['Member'].' c on b.log_AuthorID=c.mem_ID LEFT JOIN pp_plugin_shequ_user d ON c.mem_ID=d.userid LEFT JOIN '.$zbp->table['Category'].' e ON b.log_CateID = e.cate_ID'
                    , 'e.cate_ID,e.cate_Name,c.mem_ID,c.mem_Name,c.mem_alias,d.userface,d.uservip,d.userfeiwen,a.p_jiajing,a.p_feiwen,b.log_CommNums,b.log_ID,b.log_Title,b.log_PostTime'
                    , 'b.log_istop=2 and b.log_Type=0'
                    , 'b.log_ID desc'
                    , '5'
                    , ''
                ));

                ?>
                    <?php foreach ($pp_plugin_shequ_post_arr as $post=>$value) {?>

                    <li>
                        <a href="/shequ/user/home/<?php echo $value["mem_ID"];?>.html" class="fly-avatar">
                            <img src="<?php
                            if(isset($value["userface"]) && !empty($value["userface"])){
                                echo str_replace('{#ZC_BLOG_HOST#}', $zbp->host, $value["userface"]);
                            }else{
                                echo $zbp->host.'zb_users/plugin/pp_plugin_shequ/userface.jpg';
                            }?>" alt="<?php echo $value["mem_alias"];?>">
                        </a>
                        <h2>
                            <a class="layui-badge"><?php echo $value["cate_Name"];?></a>
                            <a href="<?php echo $zbp->host;?>shequ/article/<?php echo $value["log_ID"];?>.html"><?php echo $value["log_Title"];?></a>
                        </h2>
                        <div class="fly-list-info">
                            <a href="/shequ/user/home/<?php echo $value["mem_ID"];?>.html" link>
                                <cite><?php echo $value["mem_alias"];?></cite>
                                <?php
                                if(!empty($value["uservip"]) && $value["uservip"]>0){?>
                                    <i class="layui-badge fly-badge-vip">VIP<?php echo $value["uservip"];?></i>
                                <?php }?>
                            </a>
                            <span><?php echo pp_plugin_shequ_wordTime($value["log_PostTime"]);?></span>
                            <span class="fly-list-kiss layui-hide-xs" title="悬赏飞吻"><i class="iconfont icon-kiss"></i> <?php if(empty($value["p_feiwen"])){echo 0;}else{echo $value["p_feiwen"];};?></span>
                            <?php if($value["p_jietie"]==1){?>
                            <span class="layui-badge fly-badge-accept layui-hide-xs">已结</span>
                            <?php }?>
                            <span class="fly-list-nums">
                <i class="iconfont icon-pinglun1" title="回答"></i>
                                <?php if(empty($value["log_CommNums"])){echo 0;}else{echo $value["log_CommNums"];} ?>
              </span>
                        </div>
                        <div class="fly-list-badge">
                            <span class="layui-badge layui-bg-black">置顶</span>
                            <?php if($value["p_jiajing"]==1){?>
                            <span class="layui-badge layui-bg-red">精帖</span>
                            <?php }?>
                        </div>
                    </li>
                    <?php }?>
                </ul>
            </div>
            <div class="fly-panel" style="margin-bottom: 0;">
                <div class="fly-panel-title fly-filter">
                    <a href="/shequ/article/zonghe.html" <?php if($url_parm_arr[3]=="zonghe" || $url_parm_arr[2]=="index"){echo 'class="layui-this"';}?>>综合</a>
                    <span class="fly-mid"></span>
<!--                    <a href="/shequ/article/weijie.html">未结</a>-->
<!--                    <span class="fly-mid"></span>-->
                    <a href="/shequ/article/yijie.html" <?php if($url_parm_arr[3]=="yijie"){echo 'class="layui-this"';}?>>已结</a>
                    <span class="fly-mid"></span>
                    <a href="/shequ/article/jinghua.html" <?php if($url_parm_arr[3]=="jinghua"){echo 'class="layui-this"';}?>>精华</a>
                    <span class="fly-filter-right layui-hide-xs">
                    <a href="/shequ/article/zuixin.html" <?php if($url_parm_arr[3]!="reyi"){echo 'class="layui-this"';}?>>按最新</a>
                    <span class="fly-mid"></span>
                    <a href="/shequ/article/reyi.html" <?php if($url_parm_arr[3]=="reyi"){echo 'class="layui-this"';}?>>按热议</a>
                    </span>
                </div>

                <ul class="fly-list">
                    <?php
                    $pp_plugin_shequ_post_arr = $zbp->db->query($zbp->db->sql->Select(
                        $zbp->table['Post'].' b left JOIN pp_plugin_shequ_post a ON b.log_ID=a.p_postid LEFT JOIN '.$zbp->table['Member'].' c on b.log_AuthorID=c.mem_ID LEFT JOIN pp_plugin_shequ_user d ON c.mem_ID=d.userid LEFT JOIN '.$zbp->table['Category'].' e ON b.log_CateID = e.cate_ID'
                        , 'e.cate_ID,e.cate_Name,c.mem_ID,c.mem_Name,c.mem_alias,d.userface,d.uservip,d.userfeiwen,a.p_jiajing,a.p_feiwen,b.log_CommNums,b.log_ID,b.log_Title,b.log_PostTime'
                        , 'b.log_istop=0 and b.log_Type=0'
                        , 'b.log_ID desc'
                        , '15'
                        , ''
                    ));
                    ?>
                    <?php foreach ($pp_plugin_shequ_post_arr as $post=>$value) {?>
                        <li>
                            <a href="/shequ/user/home/<?php echo $value["mem_ID"];?>.html" class="fly-avatar">
                                <img src="<?php
                                if(isset($value["userface"]) && !empty($value["userface"])){
                                    echo str_replace('{#ZC_BLOG_HOST#}', $zbp->host, $value["userface"]);
                                }else{
                                    echo $zbp->host.'zb_users/plugin/pp_plugin_shequ/userface.jpg';
                                }?>" alt="<?php echo $value["mem_alias"];?>">
                            </a>
                            <h2>
                                <a class="layui-badge"><?php echo $value["cate_Name"];?></a>
                                <a href="<?php echo $zbp->host;?>shequ/article/<?php echo $value["log_ID"];?>.html"><?php echo $value["log_Title"];?></a>
                            </h2>
                            <div class="fly-list-info">
                                <a href="/shequ/user/home/<?php echo $value["mem_ID"];?>.html" link>
                                    <cite><?php echo $value["mem_alias"];?></cite>
                                    <?php
                                    if(!empty($value["uservip"]) && $value["uservip"]>0){?>
                                        <i class="layui-badge fly-badge-vip">VIP<?php echo $value["uservip"];?></i>
                                    <?php }?>
                                </a>
                                <span><?php echo pp_plugin_shequ_wordTime($value["log_PostTime"]);?></span>
                                <span class="fly-list-kiss layui-hide-xs" title="悬赏飞吻"><i class="iconfont icon-kiss"></i> <?php if(empty($value["p_feiwen"])){echo 0;}else{echo $value["p_feiwen"];};?></span>
                                <?php if($value["p_jietie"]==1){?>
                                    <span class="layui-badge fly-badge-accept layui-hide-xs">已结</span>
                                <?php }?>
                                <span class="fly-list-nums">
                <i class="iconfont icon-pinglun1" title="回答"></i>
                                    <?php if(empty($value["log_CommNums"])){echo 0;}else{echo $value["log_CommNums"];} ?>
              </span>
                            </div>
                            <div class="fly-list-badge">
                                <?php if($value["p_jiajing"]==1){?>
                                    <span class="layui-badge layui-bg-red">精帖</span>
                                <?php }?>
                            </div>
                        </li>
                    <?php }?>
                </ul>
                <div style="text-align: center">
                    <div class="laypage-main">
                        <a href="/shequ/article/more.html" class="laypage-next">更多求解</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="layui-col-md4">
            <?php require ZBP_PATH . 'zb_users/plugin/pp_plugin_shequ/html/right.php';?>
        </div>
    </div>
</div>

<?php require ZBP_PATH . 'zb_users/plugin/pp_plugin_shequ/html/footer.php';?>


