<?php
require '../../../zb_system/function/c_system_base.php';
require '../../../zb_system/function/c_system_admin.php';
$zbp->Load();
$action='root';
if (!$zbp->CheckRights($action)) {
    $zbp->ShowError(6);
    die();
}
if (!$zbp->CheckPlugin('pp_plugin_shequ')) {
    $zbp->ShowError(48);
    die();
}

$blogtitle='社区管理';
require $blogpath . 'zb_system/admin/admin_header.php';
require $blogpath . 'zb_system/admin/admin_top.php';
?>
<link href="<?php echo $zbp->host;?>zb_users/plugin/pp_plugin_shequ/res/layui/css/layui.css" rel="stylesheet" type="text/css">
<script src="<?php echo $zbp->host;?>zb_users/plugin/pp_plugin_shequ/res/layui/layui.js" type="text/javascript"></script>
<style>
    .layui-form-switch{width:55px}
</style>
<div id="divMain">
  <div class="divHeader"><?php echo $blogtitle;?></div>
  <div class="SubMenu">
<!--      <a href="#" class="m-left"><span>会员管理</span></a>-->
  </div>
  <div id="divMain2">
      <div class="layui-tab layui-tab-brief" lay-filter="shezhi">
          <ul class="layui-tab-title">
              <li lay-id="jbsz" class="layui-this">基本配置</li>
              <li lay-id="wxtd">温馨通道配置</li>
              <li lay-id="ggw">首页广告位</li>
              <li lay-id="ggwny">内容页广告位</li>
              <li lay-id="ksdl">快速登录</li>
              <li lay-id="zhifu">支付配置</li>
              <li lay-id="shop">商店配置</li>
          </ul>
          <div class="layui-tab-content">
              <div class="layui-tab-item layui-show">
                <?php require $blogpath . 'zb_users/plugin/pp_plugin_shequ/admin/jibenpeizhi.php';?>
              </div>
              <div class="layui-tab-item">
                  <?php require $blogpath . 'zb_users/plugin/pp_plugin_shequ/admin/wenxintongdao.php';?>
              </div>
              <div class="layui-tab-item">
                  <?php require $blogpath . 'zb_users/plugin/pp_plugin_shequ/admin/guanggaowei.php';?>
              </div>
              <div class="layui-tab-item">
                  <?php require $blogpath . 'zb_users/plugin/pp_plugin_shequ/admin/guanggaoweiny.php';?>
              </div>
              <div class="layui-tab-item">
                  <?php require $blogpath . 'zb_users/plugin/pp_plugin_shequ/admin/qqlogin.php';?>
              </div>
              <div class="layui-tab-item">
                  <?php require $blogpath . 'zb_users/plugin/pp_plugin_shequ/admin/zhifu.php';?>
              </div>
              <div class="layui-tab-item">
                  <?php require $blogpath . 'zb_users/plugin/pp_plugin_shequ/admin/shop.php';?>
              </div>
          </div>
      </div>
  </div>
</div>

<?php
require $blogpath . 'zb_system/admin/admin_footer.php';
RunTime();
?>
<script>
    layui.use('element', function(){
        var element = layui.element;

        //获取hash来切换选项卡，假设当前地址的hash为lay-id对应的值
        var layid = location.hash.replace(/^#sz=/, '');
        element.tabChange('shezhi', layid);

        //监听Tab切换，以改变地址hash值
        element.on('tab(shezhi)', function(){
            location.hash = 'sz='+ this.getAttribute('lay-id');
        });
    });
</script>
