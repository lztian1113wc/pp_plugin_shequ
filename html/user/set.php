<?php
/**
 * Created by PhpStorm.
 * User: wangchuan
 * Date: 2018/5/22
 * Time: 10:41
 */
global $zbp;
require ZBP_PATH . 'zb_users/plugin/pp_plugin_shequ/html/header.php';
?>
<script src="<?php echo $zbp->host;?>zb_system/script/md5.js" type="text/javascript"></script>
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
        <li class="layui-nav-item layui-this">
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
        <div class="layui-tab layui-tab-brief" lay-filter="user">
            <ul class="layui-tab-title" id="LAY_mine">
                <li class="layui-this" lay-id="info">我的资料</li>
                <li lay-id="avatar">头像</li>
                <li lay-id="pass">密码</li>
<!--                <li lay-id="bind">帐号绑定</li>-->
            </ul>
            <div class="layui-tab-content" style="padding: 20px 0;">
                <div class="layui-form layui-form-pane layui-tab-item layui-show">
                    <form method="post">
                        <div class="layui-form-item">
                            <label for="L_email" class="layui-form-label">邮箱</label>
                            <div class="layui-input-inline">
                                <input type="text" id="L_email" name="email" required lay-verify="email" autocomplete="off" value="<?php echo $zbp->user->Email;?>" class="layui-input">
                            </div>
                            <div class="layui-form-mid layui-word-aux">如果您在邮箱已激活的情况下，变更了邮箱，需<a href="activate.html" style="font-size: 12px; color: #4f99cf;">重新验证邮箱</a>。</div>
                        </div>
                        <div class="layui-form-item">
                            <label for="L_username" class="layui-form-label">昵称</label>
                            <div class="layui-input-inline">
                                <input type="text" id="L_username" name="alias" required lay-verify="required" autocomplete="off" value="<?php echo $zbp->user->Alias;?>" class="layui-input">
                            </div>
<!--                            <div class="layui-inline">-->
<!--                                <div class="layui-input-inline">-->
<!--                                    <input type="radio" name="sex" value="0" checked title="男">-->
<!--                                    <input type="radio" name="sex" value="1" title="女">-->
<!--                                </div>-->
<!--                            </div>-->
                        </div>
<!--                        <div class="layui-form-item">-->
<!--                            <label for="L_city" class="layui-form-label">城市</label>-->
<!--                            <div class="layui-input-inline">-->
<!--                                <input type="text" id="L_city" name="city" autocomplete="off" value="" class="layui-input">-->
<!--                            </div>-->
<!--                        </div>-->
                        <div class="layui-form-item layui-form-text">
                            <label for="L_sign" class="layui-form-label">签名</label>
                            <div class="layui-input-block">
                                <textarea placeholder="随便写些什么刷下存在感" id="L_sign"  name="intro" autocomplete="off" class="layui-textarea" style="height: 80px;"><?php echo $zbp->user->Intro;?></textarea>
                            </div>
                        </div>
                        <div class="layui-form-item">
                            <button class="layui-btn" key="set-mine" lay-filter="ziliao_btn" lay-submit>确认修改</button>
                        </div>
                </div>

                <div class="layui-form layui-form-pane layui-tab-item">
                    <div class="layui-form-item">
                        <div class="avatar-add">
                            <p>建议尺寸168*168，支持jpg、png、gif，最大不能超过50KB</p>
                            <button type="button" class="layui-btn upload-img" id="upload_img">
                                <i class="layui-icon">&#xe67c;</i>上传头像
                            </button>
                            <?php
                            $pp_plugin_shequ_memberExtend = new MemberExtend;
                            $pp_plugin_shequ_memberExtend->LoadInfoByField('UserId',$zbp->user->ID);
                            ?>
                            <img id="L_userface" src="<?php echo $pp_plugin_shequ_memberExtend->UserFace;?>">
                            <span class="loading"></span>
                        </div>
                    </div>
                </div>

                <div class="layui-form layui-form-pane layui-tab-item">
                    <form action="/user/repass" method="post">
                        <div class="layui-form-item">
                            <label for="L_nowpass" class="layui-form-label">当前密码</label>
                            <div class="layui-input-inline">
                                <input type="password" id="L_nowpass" name="nowpass" required lay-verify="required" autocomplete="off" class="layui-input">
                            </div>
                        </div>
                        <div class="layui-form-item">
                            <label for="L_pass" class="layui-form-label">新密码</label>
                            <div class="layui-input-inline">
                                <input type="password" id="L_pass" name="pass" required lay-verify="required" autocomplete="off" class="layui-input">
                            </div>
                            <div class="layui-form-mid layui-word-aux">6到16个字符</div>
                        </div>
                        <div class="layui-form-item">
                            <label for="L_repass" class="layui-form-label">确认密码</label>
                            <div class="layui-input-inline">
                                <input type="password" id="L_repass" name="repass" required lay-verify="required" autocomplete="off" class="layui-input">
                            </div>
                        </div>
                        <div class="layui-form-item">
                            <button class="layui-btn" key="set-mine" lay-filter="xiugaimima" lay-submit>确认修改</button>
                        </div>
                    </form>
                </div>

                <div class="layui-form layui-form-pane layui-tab-item">
                    <ul class="app-bind">
                        <li class="fly-msg app-havebind">
                            <i class="iconfont icon-qq"></i>
                            <!--<span>已成功绑定，您可以使用QQ帐号直接登录社区，当然，您也可以</span>
                            <a href="javascript:;" class="acc-unbind" type="qq_id">解除绑定</a>-->

                             <a href="" onclick="layer.msg('正在绑定微博QQ', {icon:16, shade: 0.1, time:0})" class="acc-bind" type="qq_id">立即绑定</a>
                            <span>，即可使用QQ帐号登录社区</span>
                        </li>
                        <li class="fly-msg">
                            <i class="iconfont icon-weibo"></i>
                            <!-- <span>已成功绑定，您可以使用微博直接登录社区，当然，您也可以</span>
                            <a href="javascript:;" class="acc-unbind" type="weibo_id">解除绑定</a> -->

                            <a href="" class="acc-weibo" type="weibo_id"  onclick="layer.msg('正在绑定微博', {icon:16, shade: 0.1, time:0})" >立即绑定</a>
                            <span>，即可使用微博帐号登录社区</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<?php require ZBP_PATH . 'zb_users/plugin/pp_plugin_shequ/html/footer.php'; ?>
<script>
    layui.use(['element','form','upload'],function(){
        var element = layui.element,form=layui.form,upload = layui.upload;

        form.on('submit(xiugaimima)',function(data){
            if(data.field.pass!=data.field.repass){
                layer.msg("两次输入的密码不一致",function(){});
                return false;
            }

            var url = '<?php echo $zbp->host;?>zb_users/plugin/pp_plugin_shequ/html/user/cmd.php?act=passalter';
            // data.field.nowpass=MD5(data.field.nowpass);
            // data.field.pass=MD5(data.field.pass);

            $.post(url,data.field,function(res){
                if(res==1){
                    layer.alert('修改成功',function(index){
                        layer.close(index);
                        return false;
                    })
                }else if(res==2){
                    layer.msg('原始密码不正确',function(index){});
                    return false;
                }
                else{
                    layer.msg('修改失败',function(index){});
                    return false;
                }
            })
            return false;
        })
        form.on('submit(ziliao_btn)',function(data){
            var loadindex = layer.load();
            var url = '<?php echo $zbp->host;?>zb_users/plugin/pp_plugin_shequ/html/user/cmd.php?act=set';
            $.post(url,data.field,function(res){
                if(res==1){
                    layer.alert('修改成功',function(index){
                        layer.close(index);
                        layer.close(loadindex);
                        return false;
                    })
                }else{
                    layer.msg('网络错误，请稍后再试。',function(){});
                    layer.close(loadindex);
                    return false;
                }
            })
            return false;
        })

        upload.render({
            elem: '#upload_img'
            ,url: '<?php echo $zbp->host;?>zb_users/plugin/pp_plugin_shequ/html/user/cmd.php?act=uploadUserFace'
            ,data: {} //可选项。额外的参数，如：{id: 123, abc: 'xxx'}
            ,done: function(res, index, upload){ //上传后的回调

                if(res.code == 0){
                    var userFaceUrl = res.data.src+"?r="+Math.random();
                    $("#L_userface").attr("src",userFaceUrl);
                }else{
                    layer.msg('上传失败',function(){});
                    return false;
                }
            }
        });

        //获取hash来切换选项卡，假设当前地址的hash为lay-id对应的值
        var layid = location.hash.replace(/^#tab=/, '');
        element.tabChange('user', layid);

        //监听Tab切换，以改变地址hash值
        element.on('tab(user)', function(){
            location.hash = 'tab='+ this.getAttribute('lay-id');
        });
    })
</script>
