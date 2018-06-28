<?php
/**
 * Created by PhpStorm.
 * User: wangchuan
 * Date: 2018/6/4
 * Time: 16:51
 */

?>
    <fieldset class="layui-elem-field">
        <legend>QQ登录配置</legend>
        <div class="layui-field-box">
            <form class="layui-form" action="">
                <div class="layui-form-item">
                    <label class="layui-form-label" style="width:120px">QQ登录</label>
                    <div class="layui-input-block">
                        <input type="checkbox" name="qqlogin" lay-skin="switch" lay-text="开启|关闭" <?php if($zbp->Config('pp_plugin_shequ')->qqlogin=="on"){echo "checked";}?>>
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label" style="width:120px">配置服务</label>
                    <div class="layui-input-block">
                        <a href="javascript:void(0)" onclick="toLoginpz()" style="line-height: 36px;text-decoration: underline;">打开配置页面</a>
                    </div>
                </div>

                <div class="layui-form-item">
                    <div class="layui-input-block" style="margin-left:120px">
                        <button class="layui-btn" lay-submit lay-filter="formDemo5">保存</button>
                    </div>
                </div>
            </form>
        </div>
    </fieldset>


<script>
    //Demo
    function toLoginpz(){

        var url='<?php echo $zbp->host?>zb_users/plugin/pp_plugin_shequ/app/qq/oauth/index.php';

        var iTop = (window.screen.height-30-500)/2;       //获得窗口的垂直位置;
        var iLeft = (window.screen.width-10-760)/2;        //获得窗口的水平位置;
        var A=window.open(url,"TencentLogin", "width=760,height=500,top="+iTop+",left="+iLeft+",menubar=0,scrollbars=1,resizable=1,status=1,titlebar=0,toolbar=0,location=1");
    }

    layui.use(['form','jquery'], function(){
        var form = layui.form,$=layui.jquery;

        //监听提交
        form.on('submit(formDemo5)', function(data){
            debugger;
            data.field.qqlogin = data.field.qqlogin||'off';

            $.post('<?php echo $zbp->host;?>zb_users/plugin/pp_plugin_shequ/admin/function.php?act=saveoptions5'
                ,data.field
                ,function(res){
                    layer.alert("保存成功",function(index){
                        layer.close(index);
                        return false;
                    });
                })
            return false;
        });
    });
</script>
