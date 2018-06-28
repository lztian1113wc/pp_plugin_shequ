<?php
/**
 * Created by PhpStorm.
 * User: wangchuan
 * Date: 2018/5/17
 * Time: 10:12
 */
?>
<style>
    .fly-panel-main li{display: inline-block;}
</style>
<div class="fly-panel">
    <?php
    $parm_mingcheng = $zbp->Config('pp_plugin_shequ')->wxtd_mingcheng;
    if(!empty($parm_mingcheng)){?>
    <h3 class="fly-panel-title"><?php echo $parm_mingcheng;?></h3>
    <?php } ?>
    <?php echo $zbp->Config('pp_plugin_shequ')->wxtd_neirong;?>
</div>
<!--
<div class="fly-panel fly-signin">
    <div class="fly-panel-title">
        签到
        <i class="fly-mid"></i>
        <a href="javascript:;" class="fly-link" id="LAY_signinHelp">说明</a>
        <i class="fly-mid"></i>
        <a href="javascript:;" class="fly-link" id="LAY_signinTop">活跃榜<span class="layui-badge-dot"></span></a>
        <span class="fly-signin-days">已连续签到<cite>16</cite>天</span>
    </div>
    <div class="fly-panel-main fly-signin-main">
        <button class="layui-btn layui-btn-danger" id="LAY_signin">今日签到</button>
        <span>可获得<cite>5</cite>飞吻</span>



        <button class="layui-btn layui-btn-disabled">今日已签到</button>
        <span>获得了<cite>20</cite>飞吻</span>

    </div>
</div>-->

<div class="fly-panel fly-rank fly-rank-reply" id="LAY_replyRank">
    <h3 class="fly-panel-title">回贴榜</h3>
    <dl style="text-align: left">
        <?php
        $pp_plugin_shequ_user_arr = $zbp->db->query($zbp->db->sql->Select(
            $zbp->table['Member'].' a left join pp_plugin_shequ_user b on a.mem_ID=b.userid'
            , '*'
            , ''
            , 'mem_Comments desc'
            , '12'
            , ''
        ));
        ?>
        <?php foreach ($pp_plugin_shequ_user_arr as $post=>$value) {?>
        <dd>
            <a href="/shequ/user/home/<?php echo $value["mem_ID"];?>.html">
                <img src="<?php
                if(isset($value["userface"]) && !empty($value["userface"])){
                    echo str_replace('{#ZC_BLOG_HOST#}',$zbp->host,$value["userface"]);
                }else{
                    echo $zbp->host.'zb_users/plugin/pp_plugin_shequ/userface.jpg';
                }?>" alt="<?php echo $value["mem_Alias"];?>">
                <cite><?php echo $value["mem_Alias"];?></cite>
                <i><?php echo $value["mem_Comments"];?>次回答</i>
            </a>
        </dd>
        <?php } ?>
    </dl>
</div>

<dl class="fly-panel fly-list-one">
    <dt class="fly-panel-title">热议帖子</dt>
    <?php
    $pp_plugin_shequ_post_arr = $zbp->db->query($zbp->db->sql->Select(
        $zbp->table['Post'].' b left JOIN pp_plugin_shequ_post a ON b.log_ID=a.p_postid'
        , 'b.*,a.*'
        , 'b.log_Type=0'
        , 'b.log_CommNums desc'
        , '10'
        , ''
    ));
    ?>
    <?php foreach ($pp_plugin_shequ_post_arr as $post=>$value) {?>
    <dd>
        <a href="/shequ/article/<?php echo $value["log_ID"];?>.html"><?php echo $value["log_Title"];?></a>
        <span><i class="iconfont icon-pinglun1"></i> <?php if(!empty($value["log_CommNums"])){echo $value["log_CommNums"];}else{echo '0';};?></span>
    </dd>
    <?php }?>

    <!-- 无数据时 -->
    <!--
    <div class="fly-none">没有相关数据</div>
    -->
</dl>

<div class="fly-panel">
    <div class="fly-panel-main">
        <?php echo $zbp->Config('pp_plugin_shequ')->guanggaowei_1;?>
    </div>
</div>

<div class="fly-panel fly-link">
    <h3 class="fly-panel-title">友情链接</h3>
    <ul class="fly-panel-main">
        <?php echo $zbp->modulesbyfilename['link']->Content; ?>
    </ul>
</div>
