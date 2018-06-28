<?php
/**
 * Created by PhpStorm.
 * User: wangchuan
 * Date: 2018/5/17
 * Time: 15:33
 */
?>
<form class="layui-form" action="">
    <div class="layui-form-item">
        <label class="layui-form-label">模块名</label>
        <div class="layui-input-block">
            <input type="text" name="mingcheng" placeholder="请输入模块名" autocomplete="off" class="layui-input" value="<?php echo $zbp->Config('pp_plugin_shequ')->wxtd_mingcheng;?>">
        </div>
    </div>
    <div class="layui-form-item layui-form-text">
        <label class="layui-form-label">内容</label>
        <div class="layui-input-block">
            <textarea name="neirong" style="height:400px" placeholder="请输入内容" class="layui-textarea"><?php echo $zbp->Config('pp_plugin_shequ')->wxtd_neirong;?></textarea>
        </div>
    </div>
    <div class="layui-form-item">
        <div class="layui-input-block">
            <button class="layui-btn" lay-submit lay-filter="formDemo2">保存</button>
            <button type="reset" class="layui-btn layui-btn-primary">重置</button>
        </div>
    </div>
</form>

<script>
    //Demo
    layui.use(['form','jquery'], function(){
        var form = layui.form,$=layui.jquery;

        //监听提交
        form.on('submit(formDemo2)', function(data){
            $.post('admin/function.php?act=saveoptions2',data.field,function(res){
                layer.alert("保存成功",function(index){
                    layer.close(index);
                    return false;
                });
            })
            return false;
        });
    });
</script>
