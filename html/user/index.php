<?php
/**
 * Created by PhpStorm.
 * User: wangchuan
 * Date: 2018/5/24
 * Time: 14:07
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
    <li class="layui-nav-item layui-this">
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
    <li class="layui-nav-item">
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


  <div class="fly-panel fly-panel-user" pad20>
    <!--
    <div class="fly-msg" style="margin-top: 15px;">
    您的邮箱尚未验证，这比较影响您的帐号安全，<a href="activate.html">立即去激活？</a>
    </div>
-->
      <?php
      $pp_plugin_shequ_p1 = 1;$pp_plugin_shequ_p2=1;
      $pp_plugin_shequ_p1_pagezise=15;
      $pp_plugin_shequ_p2_pagezise=15;
      if(count($url_parm_arr)>=5){$pp_plugin_shequ_p1=$url_parm_arr[4];}
      if(count($url_parm_arr)>=6){$pp_plugin_shequ_p2=$url_parm_arr[5];}

      $pp_plugin_shequ_p1_count = $zbp->db->query($zbp->db->sql->Select($zbp->table['Post'].' b left JOIN pp_plugin_shequ_post a ON b.log_ID=a.p_postid ', 'count(*)', 'b.log_Type=0 and log_AuthorID='.$zbp->user->ID,null,null,null));
      $pp_plugin_shequ_p2_count = $zbp->db->query($zbp->db->sql->Select('pp_plugin_shequ_collection', 'count(*)', 'coll_UserId='.$zbp->user->ID,null,null,null));
      $pp_plugin_shequ_p1_pagecount = ceil(current($pp_plugin_shequ_p1_count[0])/$pp_plugin_shequ_p1_pagezise);
      $pp_plugin_shequ_p2_pagecount = ceil(current($pp_plugin_shequ_p2_count[0])/$pp_plugin_shequ_p2_pagezise);

      $pp_plugin_shequ_post_arr = $zbp->db->query($zbp->db->sql->Select($zbp->table['Post'].' b left JOIN pp_plugin_shequ_post a ON b.log_ID=a.p_postid ', '*', 'b.log_Type=0 and log_AuthorID='.$zbp->user->ID, 'b.log_ID desc', array(($pp_plugin_shequ_p1-1)*$pp_plugin_shequ_p1_pagezise,$pp_plugin_shequ_p1_pagezise), ''));
      $pp_plugin_shequ_collection_arr = $zbp->db->query($zbp->db->sql->Select('pp_plugin_shequ_collection a ' .' left join '.$zbp->table['Post'].' b on a.coll_PostId=b.log_ID', '*', 'b.log_Type=0 and coll_UserId='.$zbp->user->ID, 'coll_ID desc', array(($pp_plugin_shequ_p2-1)*$pp_plugin_shequ_p2_pagezise,$pp_plugin_shequ_p2_pagezise), ''));

      ?>
    <div class="layui-tab layui-tab-brief" lay-filter="user">
      <ul class="layui-tab-title" id="LAY_mine">
        <li data-type="mine-jie" lay-id="index" class="layui-this">我发的帖（<span><?php echo current($pp_plugin_shequ_p1_count[0]);?></span>）</li>
        <li data-type="collection" data-url="/collection/find/" lay-id="collection">我收藏的帖（<span><?php echo current($pp_plugin_shequ_p2_count[0]);?></span>）</li>
      </ul>
      <div class="layui-tab-content" style="padding: 20px 0;">
        <div class="layui-tab-item layui-show">
          <ul class="mine-view jie-row">
              <?php foreach ($pp_plugin_shequ_post_arr as $post=>$value) {?>
            <li>
              <a class="jie-title" href="<?php echo $zbp->host;?>shequ/article/<?php echo $value["log_ID"];?>.html" target="_blank"><?php echo $value["log_Title"];?></a>
              <i><?php echo pp_plugin_shequ_wordTime($value["log_PostTime"]);?></i>
              <a class="mine-edit" href="<?php echo $zbp->host;?>shequ/article/edit/<?php echo $value["log_ID"];?>.html">编辑</a>
              <em><?php if(empty($value["log_ViewNums"])){echo 0;}else{echo $value["log_ViewNums"];};?>阅/<?php if(empty($value["log_CommNums"])){echo 0;}else{echo $value["log_CommNums"];};?>答</em>
            </li>
              <?php }?>
          </ul>
          <div id="LAY_page">
              <hr>
              <?php if($pp_plugin_shequ_p1>1){?>
                  <a href="<?php echo $zbp->host;?>shequ/user/index/<?php echo ($pp_plugin_shequ_p1-1);?>.html">上一页</a>
              <?php }else{?>
                  <a href="#">上一页</a>
              <?php };?>
              <?php if($pp_plugin_shequ_p1<$pp_plugin_shequ_p1_pagecount){?>
                  <a href="<?php echo $zbp->host;?>shequ/user/index/<?php echo ($pp_plugin_shequ_p1+1);?>.html">下一页</a>
              <?php }else{?>
                  <a href="#">下一页</a>
              <?php };?>
              <span>共<?php echo $pp_plugin_shequ_p1_pagecount; ?>页</span>
              <span>，当前第<?php echo $pp_plugin_shequ_p1; ?>页</span>
          </div>
        </div>
        <div class="layui-tab-item">
          <ul class="mine-view jie-row">
              <?php foreach ($pp_plugin_shequ_collection_arr as $post=>$value) {?>
            <li>
              <a class="jie-title" href="<?php echo $zbp->host;?>shequ/article/<?php echo $value["log_ID"];?>.html" target="_blank"><?php echo $value["log_Title"];?></a>
              <i>收藏于<?php echo pp_plugin_shequ_wordTime($value["coll_PostTime"]);?></i> </li>
              <?php };?>
          </ul>
          <div id="LAY_page1">
              <hr>
              <?php if($pp_plugin_shequ_p2>1){?>
                  <a href="<?php echo $zbp->host;?>shequ/user/index/<?php echo $pp_plugin_shequ_p1.'/'.($pp_plugin_shequ_p2-1);?>.html">上一页</a>
              <?php }else{?>
                  <a href="#">上一页</a>
              <?php };?>
              <?php if($pp_plugin_shequ_p2<$pp_plugin_shequ_p2_pagecount){?>
                  <a href="<?php echo $zbp->host;?>shequ/user/index/<?php echo $pp_plugin_shequ_p1.'/'.($pp_plugin_shequ_p2+1);?>.html">下一页</a>
              <?php }else{?>
                  <a href="#">下一页</a>
              <?php };?>
              <span>共<?php echo $pp_plugin_shequ_p2_pagecount; ?>页</span>
              <span>，当前第<?php echo $pp_plugin_shequ_p2; ?>页</span>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php require ZBP_PATH . 'zb_users/plugin/pp_plugin_shequ/html/footer.php'; ?>
<script>
    layui.use(['element','form','upload'],function() {
        var element = layui.element, form = layui.form, upload = layui.upload;

        //获取hash来切换选项卡，假设当前地址的hash为lay-id对应的值
        var layid = location.hash.replace(/^#tab=/, '');
        element.tabChange('user', layid);

        //监听Tab切换，以改变地址hash值
        element.on('tab(user)', function(){
            location.hash = 'tab='+ this.getAttribute('lay-id');
        });
    })
</script>

