<?php
/**
 * Created by PhpStorm.
 * User: wangchuan
 * Date: 2018/5/23
 * Time: 16:09
 */
global $zbp;
require ZBP_PATH . 'zb_users/plugin/pp_plugin_shequ/html/header.php';

$pp_plugin_shequ_userid=$zbp->user->ID;
if(isset($url_parm_arr[4]) && $url_parm_arr[4]>0){
    $pp_plugin_shequ_userid=$url_parm_arr[4];
}

$pp_plugin_shequ_memberExtend = new MemberExtend;
$pp_plugin_shequ_memberExtend->LoadInfoByField('UserId',$pp_plugin_shequ_userid);

$pp_plugin_shequ_member=new Member;
$pp_plugin_shequ_member->LoadInfoByID($pp_plugin_shequ_userid);
?>
<div class="fly-home fly-panel" style="background-image: url();">
    <img src="<?php
    if (!empty($pp_plugin_shequ_memberExtend->UserFace)) {
        echo $pp_plugin_shequ_memberExtend->UserFace;
    }else{
        echo $zbp->host.'zb_users/plugin/pp_plugin_shequ/userface.jpg';
    }
    ?>" alt="<?php echo $pp_plugin_shequ_member->Alias;?>">
<!--    <i class="iconfont icon-renzheng" title="Fly社区认证"></i>-->
    <h1>
        <?php echo $pp_plugin_shequ_member->Alias;?>
<!--        <i class="iconfont icon-nan"></i>-->
        <!-- <i class="iconfont icon-nv"></i>  -->
        <?php
        if(!empty($pp_plugin_shequ_memberExtend->UserVip)){?>
            <i class="layui-badge fly-badge-vip">VIP<?php echo $pp_plugin_shequ_memberExtend->UserVip;?></i>
        <?php } ;?>
        <?php
        if($pp_plugin_shequ_member->Level==1){?>
            <span style="color:#c00;">（管理员）</span>
        <?php } ;?>

        <!--<span style="color:#5FB878;">（社区之光）</span>
        <span>（该号已被封）</span>
        -->
    </h1>

<!--    <p style="padding: 10px 0; color: #5FB878;">认证信息：layui 作者</p>-->

    <p class="fly-home-info">
        <?php
        if(!empty($pp_plugin_shequ_memberExtend->UserFeiWen)){?>
            <i class="iconfont icon-kiss" title="飞吻"></i><span style="color: #FF7200;"><?php echo $pp_plugin_shequ_memberExtend->UserFeiWen;?> 飞吻</span>
        <?php }else{?>
            <i class="iconfont icon-kiss" title="飞吻"></i><span style="color: #FF7200;">0 飞吻</span>
        <?php } ;?>

        <i class="iconfont icon-shijian"></i><span><?php echo date('Y-m-d',$pp_plugin_shequ_member->PostTime);?> 加入</span>
<!--        <i class="iconfont icon-chengshi"></i><span>来自杭州</span>-->
    </p>

    <p class="fly-home-sign">（<?php echo $pp_plugin_shequ_member->Intro;?>）</p>

<!--    <div class="fly-sns" data-user="">-->
<!--        <a href="javascript:;" class="layui-btn layui-btn-primary fly-imActive" data-type="addFriend">加为好友</a>-->
<!--        <a href="javascript:;" class="layui-btn layui-btn-normal fly-imActive" data-type="chat">发起会话</a>-->
<!--    </div>-->

</div>

<div class="layui-container">
    <div class="layui-row layui-col-space15">
        <div class="layui-col-md6 fly-home-jie">
            <div class="fly-panel">
                <h3 class="fly-panel-title"><?php echo $pp_plugin_shequ_member->Alias;?> 最近的帖子</h3>
                <?php
                $pp_plugin_shequ_post_arr = $zbp->db->query($zbp->db->sql->Select(
                    $zbp->table['Post'].' b left JOIN pp_plugin_shequ_post a ON b.log_ID=a.p_postid LEFT JOIN '.$zbp->table['Member'].' c on b.log_AuthorID=c.mem_ID LEFT JOIN pp_plugin_shequ_user d ON c.mem_ID=d.userid LEFT JOIN '.$zbp->table['Category'].' e ON b.log_CateID = e.cate_ID'
                    , '*'
                    , 'b.log_AuthorID='.$pp_plugin_shequ_userid.' and b.log_Type=0'
                    , 'b.log_ID desc'
                    , '20'
                    , ''
                ));
                ?>
                <ul class="jie-row">
                    <?php foreach ($pp_plugin_shequ_post_arr as $post=>$value) {?>
                    <li>
                        <?php if($value["p_jiajing"]==1){?>
                        <span class="fly-jing">精</span>
                        <?php };?>
                        <a href="<?php echo $zbp->host?>shequ/article/<?php echo $value["log_ID"];?>.html" target="_blank" class="jie-title"> <?php echo $value["log_Title"];?></a>
                        <i><?php echo pp_plugin_shequ_wordTime($value["log_PostTime"]);?></i>
                        <em class="layui-hide-xs"><?php if(!empty($value["log_ViewNums"])){echo $value["log_ViewNums"];}else{echo 0;};?>阅/<?php if(!empty($value["log_CommNums"])){echo $value["log_CommNums"];}else{echo 0;};?>答</em>
                    </li>
                    <?php };?>
                    <?php if (count($pp_plugin_shequ_post_arr)==0) {?>
                     <div class="fly-none" style="min-height: 50px; padding:30px 0; height:auto;"><i style="font-size:14px;">没有发表任何求解</i></div>
                    <?php };?>
                </ul>
            </div>
        </div>

        <div class="layui-col-md6 fly-home-da">
            <div class="fly-panel">
                <h3 class="fly-panel-title"><?php echo $pp_plugin_shequ_member->Alias;?> 最近的回答</h3>
                <?php
                $pp_plugin_shequ_comment_arr = $zbp->db->query($zbp->db->sql->Select(
                    $zbp->table['Comment'].' a '
                    .'left join '.$zbp->table['Post'].' b on a.comm_LogID = b.log_ID'
                    , '*'
                    , 'a.comm_AuthorID='.$pp_plugin_shequ_userid
                    , 'a.comm_ID desc'
                    , '10'
                    , ''
                ));
                ?>
                <ul class="home-jieda">
                    <?php foreach ($pp_plugin_shequ_comment_arr as $post=>$value) {?>
                    <li>
                        <p>
                            <span><?php echo pp_plugin_shequ_wordTime($value["comm_PostTime"]);?></span>
                            在<a href="<?php echo $zbp->host?>shequ/article/<?php echo $value["log_ID"];?>.html" target="_blank"><?php echo $value["log_Title"];?></a>中回答：
                        </p>
                        <div class="home-dacontent">
                            <?php echo $value["comm_Content"];?>
                        </div>
                    </li>
                    <?php };?>
                    <?php if (count($pp_plugin_shequ_comment_arr)==0) {?>
                     <div class="fly-none" style="min-height: 50px; padding:30px 0; height:auto;"><span>没有回答任何问题</span></div>
                    <?php };?>
                </ul>
            </div>
        </div>
    </div>
</div>
<?php require ZBP_PATH . 'zb_users/plugin/pp_plugin_shequ/html/footer.php'; ?>
