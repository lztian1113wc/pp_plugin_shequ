<?php
/**
 * Created by PhpStorm.
 * User: wangchuan
 * Date: 2018/6/4
 * Time: 16:51
 */

?>

<fieldset class="layui-elem-field">
    <legend>基本配置</legend>
    <div class="layui-field-box">
        <form class="layui-form" action="">
            <div class="layui-form-item">
                <label class="layui-form-label" style="width:120px">加入导航</label>
                <div class="layui-input-block" style="margin-left: 120px;">
                    <input type="checkbox" name="is_show_in_menu" lay-skin="switch" lay-text="开启|关闭" <?php if($zbp->Config('pp_plugin_shequ')->shop_show_inmenu=="on"){echo 'checked';}?>>
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label" style="width:120px">导航名称</label>
                <div class="layui-input-block" style="margin-left: 120px;">
                    <input type="text" name="daohangming" class="layui-input" value="<?php echo $zbp->Config('pp_plugin_shequ')->shop_menu_name;?>" required lay-verify="required">
                </div>
            </div>

            <div class="layui-form-item">
                <div class="layui-input-block" style="margin-left: 120px;">
                    <button class="layui-btn" lay-submit lay-filter="formDemo8">保存</button>
                </div>
            </div>
        </form>
    </div>
</fieldset>

<script>

    layui.use(['form','jquery'], function(){
        var form = layui.form,$=layui.jquery;

        //监听提交
        form.on('submit(formDemo8)', function(data){
            data.field.is_show_in_menu =data.field.is_show_in_menu||'off';
            $.post('<?php echo $zbp->host;?>zb_users/plugin/pp_plugin_shequ/admin/function.php?act=saveoptions8'
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
