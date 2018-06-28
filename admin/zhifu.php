<?php
/**
 * Created by PhpStorm.
 * User: wangchuan
 * Date: 2018/6/4
 * Time: 16:51
 */

?>
<fieldset class="layui-elem-field">
    <legend>支付接口设置（码支付）</legend>
    <div class="layui-field-box">
        <form class="layui-form" action="">
            <div class="layui-form-item">
                <label class="layui-form-label" style="width:120px">码支付ID</label>
                <div class="layui-input-block" style="margin-left: 120px;">
                    <input type="input" class="layui-input" name="mzfid" required  lay-verify="required" value="<?php echo $zbp->Config('pp_plugin_shequ')->mzfid;?>">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label" style="width:120px">通讯密钥</label>
                <div class="layui-input-block" style="margin-left: 120px;">
                    <input type="input" class="layui-input" name="mzfmy" required  lay-verify="required" value="<?php echo $zbp->Config('pp_plugin_shequ')->mzfmy;?>">
                </div>
            </div>
            <div class="layui-form-item">
                <div class="layui-input-block" style="margin-left: 120px;">
                    <button class="layui-btn" lay-submit lay-filter="formDemo6">保存</button>
                    <a href="https://codepay.fateqq.com/" target="_blank" style="margin-left: 30px;text-decoration: underline;">码支付官网</a>
                </div>
            </div>
        </form>
    </div>
</fieldset>
<fieldset class="layui-elem-field">
    <legend>支付内容</legend>
    <div class="layui-field-box">
        <form class="layui-form" action="">
            <div class="layui-form-item">
                <label class="layui-form-label" style="width:120px">充值金额</label>
                <div class="layui-input-block" style="margin-left: 120px;">
                    <input type="input" class="layui-input" name="mzfczje" required  lay-verify="required" value="<?php echo $zbp->Config('pp_plugin_shequ')->mzfczje;?>">
                </div>
            </div>

            <div class="layui-form-item">
                <div class="layui-input-block" style="margin-left: 120px;">
                    <button class="layui-btn" lay-submit lay-filter="formDemo7">保存</button>
                </div>
            </div>
        </form>
    </div>
</fieldset>

<script>

    layui.use(['form','jquery'], function(){
        var form = layui.form,$=layui.jquery;

        //监听提交
        form.on('submit(formDemo6)', function(data){

            $.post('<?php echo $zbp->host;?>zb_users/plugin/pp_plugin_shequ/admin/function.php?act=saveoptions6'
                ,data.field
                ,function(res){
                    layer.alert("保存成功",function(index){
                        layer.close(index);
                        return false;
                    });
                })
            return false;
        });
        //监听提交
        form.on('submit(formDemo7)', function(data){

            $.post('<?php echo $zbp->host;?>zb_users/plugin/pp_plugin_shequ/admin/function.php?act=saveoptions7'
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
