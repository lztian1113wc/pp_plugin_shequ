<?php
/**
 * Created by PhpStorm.
 * User: wangchuan
 * Date: 2018/5/18
 * Time: 9:26
 */
?>

<form class="layui-form" action="">

    <div class="layui-form-item layui-form-text">
        <label class="layui-form-label" style="width:150px">右侧广告位</label>
        <div class="layui-input-block" style="margin-left: 150px;">
            <textarea name="guanggaowei1" style="height:400px" placeholder="请输入内容" class="layui-textarea"><?php echo $zbp->Config('pp_plugin_shequ')->guanggaowei_1;?></textarea>
        </div>
    </div>
    <div class="layui-form-item">
        <div class="layui-input-block">
            <button class="layui-btn" lay-submit lay-filter="formDemo3">保存</button>
            <button type="reset" class="layui-btn layui-btn-primary">重置</button>
        </div>
    </div>
</form>

<script>
    //Demo
    layui.use(['form','jquery'], function(){
        var form = layui.form,$=layui.jquery;

        //监听提交
        form.on('submit(formDemo3)', function(data){
            $.post('admin/function.php?act=saveoptions3',data.field,function(res){
                layer.alert("保存成功",function(index){
                    layer.close(index);
                    return false;
                });
            })
            return false;
        });
    });
</script>
