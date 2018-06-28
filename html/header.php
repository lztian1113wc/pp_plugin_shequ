<?php
/**
 * Created by PhpStorm.
 * User: wangchuan
 * Date: 2018/5/16
 * Time: 9:22
 */
if(!strpos($zbp->currenturl, 'login.html')) {
    setcookie("cookie_zbp_host", $zbp->currenturl, time() + 3600, $zbp->cookiespath);
}
function pp_plugin_shequ_wordTime($time) {
    $time = (int) substr($time, 0, 10);
    $int = time() - $time;
    $str = '';
    if ($int <= 2){
        $str = sprintf('刚刚', $int);
    }elseif ($int < 60){
        $str = sprintf('%d秒前', $int);
    }elseif ($int < 3600){
        $str = sprintf('%d分钟前', floor($int / 60));
    }elseif ($int < 86400){
        $str = sprintf('%d小时前', floor($int / 3600));
    }elseif ($int < 2592000){
        $str = sprintf('%d天前', floor($int / 86400));
    }else{
        $str = date('Y-m-d', $time);
    }
    return $str;
}
 ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title><?php echo $zbp->Config('pp_plugin_shequ')->title.' '.$pagetitle;?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="keywords" content="<?php echo $zbp->Config('pp_plugin_shequ')->keywords;?>">
    <meta name="description" content="<?php echo $zbp->Config('pp_plugin_shequ')->description;?>">
    <link rel="stylesheet" href="<?php echo $zbp->host;?>zb_users/plugin/pp_plugin_shequ/res/layui/css/layui.css">
    <link rel="stylesheet" href="<?php echo $zbp->host;?>zb_users/plugin/pp_plugin_shequ/res/css/global.css">
    <script src="<?php echo $zbp->host;?>zb_users/plugin/pp_plugin_shequ/res/layui/layui.js"></script>
    <script src="<?php echo $zbp->host;?>zb_users/plugin/pp_plugin_shequ/res/jquery-1.8.3.min.js"></script>
    <style>
        #pp_plugin_shequ_menu li{
            position: relative;
            display: inline-block;
            vertical-align: middle;
            line-height: 60px;
            font-size: 14px;
        }
        #pp_plugin_shequ_menu li a{
            color:rgba(255,255,255,.7);
            padding: 0 25px 0 25px;
        }
        #pp_plugin_shequ_menu li a:hover{
             color:#fff;
         }
        .pagebar .now-page{
            color:red;
        }
    </style>
</head>
<body>

<div class="fly-header layui-bg-black">
    <div class="layui-container">
        <a class="fly-logo" href="/">
            <img src="<?php
            if(!$zbp->Config('pp_plugin_shequ')->HasKey('logo')){
                echo $zbp->host.'zb_users/plugin/pp_plugin_shequ/html/logo.png';
            }else{
                echo $zbp->Config('pp_plugin_shequ')->logo;
            }
            ?>" alt="<?php echo $zbp->Config('pp_plugin_shequ')->title;?>">
        </a>
        <ul id="pp_plugin_shequ_menu" class="layui-nav fly-nav layui-hide-xs">
            <?php echo $zbp->modulesbyfilename['navbar']->Content; ?>
        </ul>

        <ul class="layui-nav fly-nav-user">
            <?php if(empty($zbp->user->ID)) {?>
            <!-- 未登入的状态 -->
            <li class="layui-nav-item">
                <a class="iconfont icon-touxiang layui-hide-xs" href="/shequ/user/login.html"></a>
            </li>
            <li class="layui-nav-item">
                <a href="/shequ/user/login.html">登入</a>
            </li>
            <li class="layui-nav-item">
                <a href="/shequ/user/reg.html">注册</a>
            </li>
            <?php if($zbp->Config('pp_plugin_shequ')->qqlogin=="on"){?>
            <li class="layui-nav-item layui-hide-xs">
                <a href="<?php echo $zbp->host?>shequ/qqlogin/index.html" onclick="layer.msg('正在通过QQ登入', {icon:16, shade: 0.1, time:0})" title="QQ登入" class="iconfont icon-qq"></a>
            </li>
            <?php };?>
<!--            <li class="layui-nav-item layui-hide-xs">-->
<!--                <a href="/app/weibo/" onclick="layer.msg('正在通过微博登入', {icon:16, shade: 0.1, time:0})" title="微博登入" class="iconfont icon-weibo"></a>-->
<!--            </li>-->
            <?php
                } else {
                $pp_plugin_shequ_user_info = new MemberExtend;
                $pp_plugin_shequ_user_info->LoadInfoByField('UserId',$zbp->user->ID);

                $pp_plugin_shequ_detail_comment_count_arr = $zbp->db->query($zbp->db->sql->Select('pp_plugin_shequ_message', 'count(*)', 'mess_ToUserId=' . $zbp->user->ID, '', '', ''));
                $pp_plugin_shequ_detail_comment_count = current($pp_plugin_shequ_detail_comment_count_arr[0]);
                ?>
            <li class="layui-nav-item">
              <a class="fly-nav-avatar" href="/shequ/user/home.html" id="ppshequ_user_home">
                <cite class="layui-hide-xs"><?php echo $zbp->user->Alias; ?></cite>
<!--              <i class="iconfont icon-renzheng layui-hide-xs" title="认证信息：layui 作者"></i>-->
                  <?php
                  if(!empty($pp_plugin_shequ_user_info->UserVip) && $pp_plugin_shequ_user_info-UserVip>0){?>
                      <i class="layui-badge fly-badge-vip layui-hide-xs">VIP<?php echo $pp_plugin_shequ_user_info->UserVip;?></i>
                  <?php }?>
                  <img src="<?php
                  if(isset($pp_plugin_shequ_user_info->UserFace) && !empty($pp_plugin_shequ_user_info->UserFace)){
                      echo $pp_plugin_shequ_user_info->UserFace;
                  }else{
                      echo $zbp->host.'zb_users/plugin/pp_plugin_shequ/userface.jpg';
                  }?>" alt="<?php echo $zbp->user->Alias;?>">
                  <?php if($pp_plugin_shequ_detail_comment_count>0){?><span class="layui-badge-dot" style="right:35px"></span><?php };?>
              </a>
              <dl class="layui-nav-child" id="ppshequ_user_home_child">
                <dd><a href="/shequ/user/set.html"><i class="layui-icon">&#xe620;</i>基本设置</a></dd>
                <dd>
                    <a href="/shequ/user/message.html"><i class="iconfont icon-tongzhi" style="top: 4px;"></i>我的消息</a>
                    <?php if($pp_plugin_shequ_detail_comment_count>0){?><span class="layui-badge-dot" style="right:0px"></span><?php };?>
                </dd>
                <dd><a href="/shequ/user/home.html"><i class="layui-icon" style="margin-left: 2px; font-size: 22px;">&#xe68e;</i>我的主页</a></dd>
                <hr style="margin: 5px 0;">
                <dd><a href="/shequ/user/zhanghu.html"><i class="layui-icon" style="margin-left: 2px; font-size: 22px;">&#xe66c;</i>我的账户</a></dd>
                <?php if($zbp->CheckRights('root')){?><dd><a href="/shequ/user/shop.html"><i class="layui-icon" style="margin-left: 2px; font-size: 22px;">&#xe698;</i>我的商店</a></dd><?php };?>
                <hr style="margin: 5px 0;">
                <dd><a href="<?php echo $zbp->host;?>zb_system/cmd.php?act=logout&csrfToken=<?php
                    //$s = $zbp->user->ID . $zbp->user->Password . $zbp->user->Status;
                    echo md5($zbp->guid . $zbp->user->ID . $zbp->user->Password . $zbp->user->Status . date('Ymdh'))
                    ?>" style="text-align: center;">退出</a></dd>
              </dl>
            </li>
            <?php } ?>
        </ul>
    </div>
</div>


<script>
    function toLogin(){
        var url='<?php echo $zbp->host?>shequ/qqlogin/index.html';
        //var url='<?php echo $zbp->host?>zb_users/plugin/pp_plugin_shequ/app/qq/oauth/index.php';

        var iTop = (window.screen.height-30-500)/2;       //获得窗口的垂直位置;
        var iLeft = (window.screen.width-10-760)/2;        //获得窗口的水平位置;
        var A=window.open(url,"TencentLogin", "width=760,height=500,top="+iTop+",left="+iLeft+",menubar=0,scrollbars=1,resizable=1,status=1,titlebar=0,toolbar=0,location=1");
    }

    $(function(){
        (function(){
            var t=true;
            $("#ppshequ_user_home").hover(
                function(){
                    $("#ppshequ_user_home_child").show();
                },function(){
                    setTimeout(function(){
                        if(t){
                            $("#ppshequ_user_home_child").hide();
                        }
                    },1000)
                });

            $("#ppshequ_user_home_child").hover(
                function(){
                    t=false;
                    $("#ppshequ_user_home_child").show();
                },function(){
                    t=true;
                    $("#ppshequ_user_home_child").hide();
                });
        })();
    })


</script>