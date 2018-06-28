<?php
/**
 * Created by PhpStorm.
 * User: wangchuan
 * Date: 2018/5/29
 * Time: 10:20
 */
?>

<div class="layui-col-md4">
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
<!--        <div class="fly-panel-title">-->
<!---->
<!--        </div>-->
        <div class="fly-panel-main">
            <?php echo $zbp->Config('pp_plugin_shequ')->guanggaowei_2;?>
        </div>
    </div>

<!--    <div class="fly-panel" style="padding: 20px 0; text-align: center;">-->
<!--        <img src="../../res/images/weixin.jpg" style="max-width: 100%;" alt="layui">-->
<!--        <p style="position: relative; color: #666;">微信扫码关注 layui 公众号</p>-->
<!--    </div>-->

</div>
