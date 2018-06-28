<?php
/**
 * Created by PhpStorm.
 * User: wangchuan
 * Date: 2018/5/21
 * Time: 11:21
 */

global $zbp;
require ZBP_PATH . 'zb_users/plugin/pp_plugin_shequ/html/header.php';
?>
<script src="<?php echo $zbp->host;?>zb_system/script/md5.js" type="text/javascript"></script>
<script src="<?php echo $zbp->host;?>zb_users/plugin/pp_plugin_shequ/res/jquery.cookie.js" type="text/javascript"></script>
<div class="layui-container fly-marginTop">
    <div class="fly-panel fly-panel-user" pad20>
        <div class="layui-tab layui-tab-brief" lay-filter="user">
            <ul class="layui-tab-title">
                <li class="layui-this">登入</li>
                <li><a href="reg.html">注册</a></li>
            </ul>
            <div class="layui-form layui-tab-content" id="LAY_ucm" style="padding: 20px 0;">
                <div class="layui-tab-item layui-show">
                    <div class="layui-form layui-form-pane">
                        <form id="userlogin_form" method="post" action="">
                            <div class="layui-form-item">
                                <label for="L_username" class="layui-form-label">帐号</label>
                                <div class="layui-input-inline">
                                    <input type="text" id="L_username" name="username" required lay-verify="required" autocomplete="off" class="layui-input">
                                </div>
                            </div>
                            <div class="layui-form-item">
                                <label for="L_password" class="layui-form-label">密码</label>
                                <div class="layui-input-inline">
                                    <input type="password" id="L_password" name="password" required lay-verify="required" autocomplete="off" class="layui-input">
                                </div>
                            </div>
<!--                            <div class="layui-form-item">-->
<!--                                <label for="L_vercode" class="layui-form-label">人类验证</label>-->
<!--                                <div class="layui-input-inline">-->
<!--                                    <input type="text" id="L_vercode" name="vercode" required lay-verify="required" placeholder="请回答后面的问题" autocomplete="off" class="layui-input">-->
<!--                                </div>-->
<!--                                <div class="layui-form-mid">-->
<!--                                    <span style="color: #c00;">{{d.vercode}}</span>-->
<!--                                </div>-->
<!--                            </div>-->
                            <div class="layui-form-item">
                                <button class="layui-btn" lay-filter="userlogin" lay-submit>立即登录</button>
                                <span style="padding-left:20px;">
                  <a href="forget.html">忘记密码？</a>
                </span>
                            </div>
                            <?php if($zbp->Config('pp_plugin_shequ')->qqlogin=="on"){?>
                            <div class="layui-form-item fly-form-app">
                                <span>或者使用社交账号登入</span>
                                <a href="<?php echo $zbp->host?>shequ/qqlogin/index.html" onclick="layer.msg('正在通过QQ登入', {icon:16, shade: 0.1, time:0})" class="iconfont icon-qq" title="QQ登入"></a>
                            </div>
                            <?php };?>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php require ZBP_PATH . 'zb_users/plugin/pp_plugin_shequ/html/footer.php'; ?>
<script>

    layui.use('form',function(){
        var form = layui.form;
        form.on('submit(userlogin)',function(data){
            var loginindex = layer.load();

            data.field.password = MD5(data.field.password);
            var url = '<?php echo $zbp->host;?>zb_users/plugin/pp_plugin_shequ/html/user/cmd.php?act=login';
            $.post(url,data.field,function(res){
                if('success'==res){
                    var returnurl = '<?php echo empty($_SERVER['HTTP_REFERER'])?$zbp->host.'shequ/index.html':$_SERVER['HTTP_REFERER'];?>';
                    window.location.href=returnurl;
                    layer.close(loginindex);
                }else{
                    layer.msg('用户名或密码错误',function(){});
                    layer.close(loginindex);
                    return false;
                }
            })
            return false;
        })
    })
</script>
