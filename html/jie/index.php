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

            <div class="fly-panel" style="margin-bottom: 0;">
                <div class="fly-panel-title fly-filter">
                    <a href="/shequ/article/zonghe.html" <?php if($url_parm_arr[3]=="zonghe"){echo 'class="layui-this"';}?>>综合</a>
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

                    $pp_plugin_shequ_index_post_category_w[]=array('=','b.log_Type','0');
                    $pp_plugin_shequ_index_post_category_o=' b.log_ID desc';

                    if(is_numeric($url_parm_arr[3])){
                        $pp_plugin_shequ_index_post_category_w[]=array('=','b.log_CateID',$url_parm_arr[3]);
                    }else if($url_parm_arr[3]=="yijie"){
                        $pp_plugin_shequ_index_post_category_w[]=array('=','a.p_jietie',1);
                    }else if($url_parm_arr[3]=="jinghua"){
                        $pp_plugin_shequ_index_post_category_w[]=array('=','a.p_jiajing',1);
                    }else if($url_parm_arr[3]=="zuixin"){
                        $pp_plugin_shequ_index_post_category_o=' b.log_ID desc';
                    }else if($url_parm_arr[3]=="reyi"){
                        $pp_plugin_shequ_index_post_category_o=' b.log_CommNums desc';
                    }

                    $pp_plugin_shequ_index_post_page=1;
                    $pp_plugin_shequ_index_post_pagesize=25;
                    if(count($url_parm_arr)>=5){$pp_plugin_shequ_index_post_page=$url_parm_arr[4];}
                    $pp_plugin_shequ_index_post_count=$zbp->db->query($zbp->db->sql->Select(
                        $zbp->table['Post'].' b left JOIN pp_plugin_shequ_post a ON b.log_ID=a.p_postid LEFT JOIN '.$zbp->table['Member'].' c on b.log_AuthorID=c.mem_ID LEFT JOIN pp_plugin_shequ_user d ON c.mem_ID=d.userid LEFT JOIN '.$zbp->table['Category'].' e ON b.log_CateID = e.cate_ID', 'count(*)', 'b.log_istop=0 and b.log_Type=0', 'b.log_ID desc', '', ''));
                    $pp_plugin_shequ_index_post_pagecount = ceil(current($pp_plugin_shequ_index_post_count[0])/$pp_plugin_shequ_index_post_pagesize);

                    $pp_plugin_shequ_post_arr_sql=$zbp->db->sql->Select(
                        $zbp->table['Post'].' b left JOIN pp_plugin_shequ_post a ON b.log_ID=a.p_postid LEFT JOIN '.$zbp->table['Member'].' c on b.log_AuthorID=c.mem_ID LEFT JOIN pp_plugin_shequ_user d ON c.mem_ID=d.userid LEFT JOIN '.$zbp->table['Category'].' e ON b.log_CateID = e.cate_ID'
                        , 'e.cate_ID,e.cate_Name,c.mem_ID,c.mem_Name,c.mem_alias,d.userface,d.uservip,d.userfeiwen,a.p_jiajing,a.p_feiwen,b.log_CommNums,b.log_ID,b.log_Title,b.log_PostTime'
                        ,$pp_plugin_shequ_index_post_category_w
                        ,$pp_plugin_shequ_index_post_category_o
                        , array(($pp_plugin_shequ_index_post_page-1)*$pp_plugin_shequ_index_post_pagesize,$pp_plugin_shequ_index_post_pagesize)
                        , ''
                    );
                    $pp_plugin_shequ_post_arr = $zbp->db->query($pp_plugin_shequ_post_arr_sql);
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
                    <hr/>
                    <?php if($pp_plugin_shequ_index_post_page>1){?>
                        <a href="<?php echo $zbp->host;?>shequ/category/<?php echo $url_parm_arr[3].'/'; echo ($pp_plugin_shequ_index_post_page-1);?>.html">上一页</a>
                    <?php }else{?>
                        <a href="javascript:void(0)">上一页</a>
                    <?php };?>
                    <?php if($pp_plugin_shequ_index_post_page<$pp_plugin_shequ_index_post_pagecount){?>
                        <a href="<?php echo $zbp->host;?>shequ/category/<?php echo $url_parm_arr[3].'/';echo ($pp_plugin_shequ_index_post_page+1);?>.html">下一页</a>
                    <?php }else{?>
                        <a href="javascript:void(0)">下一页</a>
                    <?php };?>
                    <span>共<?php echo $pp_plugin_shequ_index_post_pagecount; ?>页</span>
                    <span>，当前第<?php echo $pp_plugin_shequ_index_post_page; ?>页</span>
                    <br/>
                    <br/>
                </div>
            </div>
        </div>
        <div class="layui-col-md4">
            <?php require ZBP_PATH . 'zb_users/plugin/pp_plugin_shequ/html/right.php';?>
        </div>
    </div>
</div>

<?php require ZBP_PATH . 'zb_users/plugin/pp_plugin_shequ/html/footer.php';?>


