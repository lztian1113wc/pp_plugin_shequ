<?php
/**
 * Created by PhpStorm.
 * User: wangchuan
 * Date: 2018/5/14
 * Time: 14:31
 */
?>
<form class="layui-form" action="">
    <div class="layui-form-item">
        <label class="layui-form-label" style="width:150px">添加到首页导航</label>
        <div class="layui-input-inline">
            <input type="checkbox" name="is_show_in_menu" lay-skin="switch" lay-text="开启|关闭" <?php if($zbp->Config('pp_plugin_shequ')->is_show_in_menu=="on"){echo 'checked';}?>>
        </div>
        <div class="layui-form-mid layui-word-aux">开启后，会在前台导航条加入‘社区’的链接。</div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label" style="width:150px">设为默认首页</label>
        <div class="layui-input-inline">
            <input type="checkbox" name="isdefaultpage" lay-skin="switch" lay-text="开启|关闭" <?php if($zbp->Config('pp_plugin_shequ')->isdefaultpage=="on"){echo 'checked';}?>>
        </div>
        <div class="layui-form-mid layui-word-aux">开启后，社区首页将作为站点的默认首页。</div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label" style="width:150px">社区LOGO</label>
        <div class="layui-input-block" style="margin-left:150px">
            <img id="L_logo_upload" src="<?php
            if(!$zbp->Config('pp_plugin_shequ')->HasKey('logo')){
                echo $zbp->host.'zb_users/plugin/pp_plugin_shequ/html/logo.png';
            }else{
                echo $zbp->Config('pp_plugin_shequ')->logo;
            }
            ?>">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label" style="width:150px">社区标题</label>
        <div class="layui-input-block" style="margin-left:150px">
            <input type="text" name="title" required  lay-verify="required" placeholder="请输入标题" autocomplete="off" class="layui-input" value="<?php echo $zbp->Config('pp_plugin_shequ')->title;?>">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label" style="width:150px">关键词</label>
        <div class="layui-input-block" style="margin-left:150px">
            <input type="text" name="keywords" required  lay-verify="required" placeholder="请输入关键词" autocomplete="off" class="layui-input" value="<?php echo $zbp->Config('pp_plugin_shequ')->keywords;?>">
        </div>
    </div>
    <div class="layui-form-item layui-form-text">
        <label class="layui-form-label" style="width:150px">社区简介</label>
        <div class="layui-input-block" style="margin-left:150px">
            <textarea name="description" placeholder="请输入社区简介" class="layui-textarea"><?php echo $zbp->Config('pp_plugin_shequ')->description;?></textarea>
        </div>
    </div>
    <div class="layui-form-item layui-form-text">
        <label class="layui-form-label" style="width:150px">底部信息</label>
        <div class="layui-input-block" style="margin-left:150px">
            <textarea name="footermessage" placeholder="信息会显示在站点底部" class="layui-textarea"><?php echo $zbp->Config('pp_plugin_shequ')->footermessage;?></textarea>
        </div>
    </div>
    <div class="layui-form-item">
        <div class="layui-input-block">
            <button class="layui-btn" lay-submit lay-filter="formDemo">保存</button>
            <button type="reset" class="layui-btn layui-btn-primary">重置</button>
        </div>
    </div>
</form>

<script>
    //Demo
    layui.use(['form','jquery','upload'], function(){
        var form = layui.form,$=layui.jquery,upload=layui.upload;

        upload.render({
            elem: '#L_logo_upload'
            ,url: '<?php echo $zbp->host;?>zb_users/plugin/pp_plugin_shequ/html/user/cmd.php?act=uploadlogo'
            ,data: {} //可选项。额外的参数，如：{id: 123, abc: 'xxx'}
            ,done: function(res, index, upload){ //上传后的回调

                if(res.code == 0){
                    var userFaceUrl = res.data.src+"?r="+Math.random();
                    $("#L_logo_upload").attr("src",userFaceUrl);
                }else{
                    layer.msg('上传失败',function(){});
                    return false;
                }
            }
        });

        //监听提交
        form.on('submit(formDemo)', function(data){
            data.field.is_show_in_menu=data.field.is_show_in_menu||'off';
            data.field.isdefaultpage=data.field.isdefaultpage||'off';

            $.post('<?php echo $zbp->host;?>zb_users/plugin/pp_plugin_shequ/admin/function.php?act=saveoptions'
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
