<?php
require '../../../../../zb_system/function/c_system_base.php';
require '../../../../../zb_system/function/c_system_admin.php';
$zbp->Load();
$action = 'root';
if (!$zbp->CheckRights($action)) {
    $zbp->ShowError(6);
    die();
}
if (!$zbp->CheckPlugin('pp_plugin_shequ')) {
    $zbp->ShowError(48);
    die();
}

$goodsid = GetVars('goodsid', 'GET');
$pp_plugin_shequ_goodsinfo = $zbp->pp_plugin_shequ_getgoodsinfo($goodsid);
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="<?php echo $zbp->host; ?>zb_users/plugin/pp_plugin_shequ/res/layui/css/layui.css">
    <script src="<?php echo $zbp->host; ?>zb_users/plugin/pp_plugin_shequ/res/layui/layui.js"></script>
    <script src="<?php echo $zbp->host; ?>zb_users/plugin/pp_plugin_shequ/res/jquery-1.8.3.min.js"></script>
    <title></title>
</head>
<body>
<div class="layui-form">
    <div class="layui-form-item">
        <label class="layui-form-label">商品分类</label>
        <div class="layui-input-block">
            <select name="goodsType" lay-verify="">
                <?php
                $pp_plugin_shequ_zbpFunction = new pp_plugin_shequ_zbpFunction();
                foreach($pp_plugin_shequ_zbpFunction->pp_plugin_shequ_shop_getGoodsTypeList() as $goodsType){
                    if($pp_plugin_shequ_goodsinfo->TypeId==$goodsType->ID){
                        echo '<option value="'.$goodsType->ID.'" checked>'.$goodsType->Name.'</option>';
                    }else{
                        echo '<option value="'.$goodsType->ID.'">'.$goodsType->Name.'</option>';
                    }
                }
                ?>
            </select>

        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">商品名称</label>
        <div class="layui-input-block">
            <input type="hidden" name="id" value="<?php echo $goodsid; ?>">
            <input name="goodsname" class="layui-input" required lay-verify="required"
                   value="<?php echo $pp_plugin_shequ_goodsinfo->Name; ?>"/>
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">商品图片</label>
        <div class="layui-input-block" style="height: 100px;">
            <img id="L_goods_img" style="width:90px;height:90px" src="<?php echo $pp_plugin_shequ_goodsinfo->Metas->goodspic;?>">
            <i id="L_goods_img_btn" class="layui-icon" style="cursor:pointer;font-size: 80px;position: absolute;top: 5px;">&#xe608;</i>
            <input id="L_goods_img_path" type="hidden" name="goodspic" value="<?php echo $pp_plugin_shequ_goodsinfo->Metas->goodspic;?>">
        </div>
    </div>
    <div class="layui-form-item">
        <div class="layui-inline">
            <label class="layui-form-label">商品价格</label>
            <div class="layui-input-inline">
                <input name="goodsprice" class="layui-input" required lay-verify="required"
                       value="<?php echo $pp_plugin_shequ_goodsinfo->Metas->goodsprice; ?>"/>
            </div>
        </div>
        <div class="layui-inline">
            <label class="layui-form-label">促销价</label>
            <div class="layui-input-inline">
                <input name="goodsprice_cx" class="layui-input"
                       value="<?php echo $pp_plugin_shequ_goodsinfo->Metas->goodsprice_cx; ?>"/>
            </div>
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">是否促销</label>
        <div class="layui-input-inline">
            <input type="checkbox" name="shifoucuxiao" lay-skin="switch"
                   lay-text="开启|关闭" <?php echo $pp_plugin_shequ_goodsinfo->Metas->shifoucuxiao == 'on' ? 'checked' : ''; ?>>
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">促销类型</label>
        <div class="layui-input-inline">
            <input type="radio" name="cuxiaofenlei" lay-filter="cuxiaofenlei" value="1"
                   title="时间" <?php echo $pp_plugin_shequ_goodsinfo->Metas->cuxiaofenlei == 1 ? 'checked' : ''; ?>>
            <input type="radio" name="cuxiaofenlei" lay-filter="cuxiaofenlei" value="2"
                   title="数量" <?php echo $pp_plugin_shequ_goodsinfo->Metas->cuxiaofenlei == 2 ? 'checked' : ''; ?>>
        </div>
    </div>
    <div class="layui-form-item <?php echo $pp_plugin_shequ_goodsinfo->Metas->cuxiaofenlei == 2 ? 'layui-hide' : ''; ?>" id="cuxiaofenlei_sj" >
        <label class="layui-form-label">促销时间</label>
        <div class="layui-input-inline">
            <input name="cuxiaoshijian_ks" class="layui-input" id="cuxiaoshijian_ks"
                   value="<?php echo $pp_plugin_shequ_goodsinfo->Metas->cuxiaoshijian_ks; ?>"/>
        </div>
        <div class="layui-input-inline">
            <input name="cuxiaoshijian_js" class="layui-input" id="cuxiaoshijian_js"
                   value="<?php echo $pp_plugin_shequ_goodsinfo->Metas->cuxiaoshijian_js; ?>"/>
        </div>
    </div>
    <div class="layui-form-item <?php echo $pp_plugin_shequ_goodsinfo->Metas->cuxiaofenlei == 1 ? 'layui-hide' : ''; ?>" id="cuxiaofenlei_sl">
        <label class="layui-form-label">促销数量</label>
        <div class="layui-input-block">
            <input name="cuxiaoshuliang" class="layui-input"
                   value="<?php echo $pp_plugin_shequ_goodsinfo->Metas->cuxiaoshuliang; ?>"/>
        </div>
    </div>
    <div class="layui-form-item layui-form-text">
        <label class="layui-form-label">购买须知</label>
        <div class="layui-input-block">
            <textarea id="L_desc" placeholder="请输入内容"
                      class="layui-textarea"><?php echo $pp_plugin_shequ_goodsinfo->Desc; ?></textarea>
        </div>
    </div>
    <div class="layui-form-item ">
        <label class="layui-form-label">提取地址</label>
        <div class="layui-input-block">
            <input name="tiqudizhi" class="layui-input"
                   value="<?php echo $pp_plugin_shequ_goodsinfo->Url; ?>"/>
        </div>
    </div>
    <div class="layui-form-item ">
        <label class="layui-form-label">提取码</label>
        <div class="layui-input-block">
            <input name="tiquma" class="layui-input"
                   value="<?php echo $pp_plugin_shequ_goodsinfo->Tiquma; ?>"/>
        </div>
    </div>
    <div class="layui-form-item layui-form-text">
        <label class="layui-form-label">商品详情</label>
        <div class="layui-input-block">
            <textarea id="L_info" placeholder="请输入内容"
                      class="layui-textarea"><?php echo $pp_plugin_shequ_goodsinfo->Content; ?></textarea>
        </div>
    </div>
    <div class="layui-form-item layui-form-text" style="text-align: center">
        <button class="layui-btn" lay-submit lay-filter="goodsedit">保存修改</button>
    </div>
</div>
</body>
</html>
<script>
    layui.use(['element', 'form', 'layedit', 'laydate','upload'], function () {
        var element = layui.element, form = layui.form, layedit = layui.layedit, laydate = layui.laydate,upload=layui.upload;
        layedit.set({uploadImage: {url: '<?php echo $zbp->host;?>zb_users/plugin/pp_plugin_shequ/html/user/cmd.php?act=upload'}});
        var editIndex_desc = layedit.build('L_desc'); //建立编辑器
        var editIndex_info = layedit.build('L_info'); //建立编辑器
        //var content = layedit.getContent(editIndex_desc);//获取编辑器内容

        upload.render({
            elem: '#L_goods_img_btn'
            ,url: '<?php echo $zbp->host;?>zb_users/plugin/pp_plugin_shequ/html/user/cmd.php?act=upload'
            ,data: {} //可选项。额外的参数，如：{id: 123, abc: 'xxx'}
            ,done: function(res, index, upload){ //上传后的回调

                if(res.code == 0){
                    var userFaceUrl = res.data.src+"?r="+Math.random();
                    $("#L_goods_img_path").val(res.data.src);

                    $("#L_goods_img").attr({
                        src:userFaceUrl
                    }).css({
                        width:'90px',
                        height:'90px'
                    });
                }else{
                    layer.msg('上传失败',function(){});
                    return false;
                }
            }
        });

        form.on('submit(goodsedit)', function (data) {
            var loadIndex = layer.load();
            data.field.shifoucuxiao = data.field.shifoucuxiao || "off";
            data.field.desc = layedit.getContent(editIndex_desc) || '';
            data.field.content = layedit.getContent(editIndex_info) || '';
            //layer.alert(JSON.stringify(data.field));
            var url = '<?php echo $zbp->host;?>zb_users/plugin/pp_plugin_shequ/html/user/cmd.php?act=goodsedit';
            $.post(url, data.field, function (res) {
                if (res == 1) {
                    layer.alert('修改成功', function (index) {
                        //假设这是iframe页
                        parent.window.location.reload();
                        return false;
                    });
                    layer.close(loadIndex);
                    return false;
                } else {
                    layer.msg('修改失败', function () {
                    });
                    return false;
                }
            })
            return false;
        });

        form.on('radio(cuxiaofenlei)', function (data) {
            if (data.value == 1) {
                $("#cuxiaofenlei_sj").addClass('layui-show');
                $("#cuxiaofenlei_sl").addClass('layui-hide');
                $("#cuxiaofenlei_sj").removeClass('layui-hide');

            } else {
                $("#cuxiaofenlei_sl").addClass('layui-show');
                $("#cuxiaofenlei_sj").addClass('layui-hide');
                $("#cuxiaofenlei_sl").removeClass('layui-hide');
            }
        });

        laydate.render({
            elem: '#cuxiaoshijian_ks'
            , format: 'yyyy-MM-dd'
        });
        laydate.render({
            elem: '#cuxiaoshijian_js'
            , format: 'yyyy-MM-dd'
        });
    })
</script>