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
        <li class="layui-nav-item">
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
        <li class="layui-nav-item layui-this">
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
                <li class="layui-this" lay-id="splb">商品列表</li>
                <li lay-id="spsj">商品上架</li>
                <li lay-id="spfl">商品分类</li>
                <li lay-id="yslb">已售列表</li>
            </ul>
            <div class="layui-tab-content" style="padding: 20px 0;">
                <div class="layui-form layui-tab-item layui-show">
                    <table class="layui-table">
                        <colgroup>
                            <col width="80">
                            <col>
                            <col width="80">
                            <col width="100">
                            <col width="80">
                            <col width="150">
                        </colgroup>
                        <thead>
                        <tr>
                            <th>编号</th>
                            <th>商品名</th>
                            <th>价格</th>
                            <th>是否促销</th>
                            <th>促销价</th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $p = new pp_plugin_shequ_pagebar('{%host%}shequ/user/shop/{%page%}.html', false);
                        $p->PageCount = 20;//$zbp->managecount;
                        $p->PageNow = count($url_parm_arr)==5?$url_parm_arr[4]:1;
                        $p->PageBarCount = $zbp->pagebarcount;

                        $sql = $zbp->db->sql->select(
                            $zbp->table['pp_plugin_shequ_goods']
                            ,'*'
                            ,''
                            ,'goods_posttime desc'
                            ,array(($p->PageNow - 1) * $p->PageCount, $p->PageCount)
                            ,array('pagebar' => $p)
                        );
                        ?>
                        <?php foreach($zbp->pp_plugin_shequ_getgoodslist($sql) as $goods){?>
                        <tr>
                            <td><?php echo $goods->ID;?></td>
                            <td><a target="_blank" href="<?php echo $zbp->host?>shequ/shop/info/<?php echo $goods->ID;?>.html"><?php echo $goods->Name;?></a></td>
                            <td><?php echo $goods->Metas->goodsprice;?></td>
                            <td><?php echo $goods->Metas->shifoucuxiao=='off'?'否':'是';?></td>
                            <td><?php echo $goods->Metas->goodsprice_cx?></td>
                            <td>
                                <button class="layui-btn layui-btn-xs" name="goodslist_bianji" data_id="<?php echo $goods->ID;?>">编辑</button>
                                <button class="layui-btn layui-btn-xs layui-btn-danger" name="goodslist_shanchu" data_id="<?php echo $goods->ID;?>">删除</button>
                            </td>
                        </tr>
                        <?php };?>
                        </tbody>
                    </table>
                    <?php
                    echo '<hr/><p class="pagebar">';
                    foreach ($p->Buttons as $key => $value) {
                        if ($p->PageNow == $key) {
                            echo '<span class="now-page">' . $key . '</span>&nbsp;&nbsp;';
                        } else {
                            echo '<a href="' . $value . '">' . $key . '</a>&nbsp;&nbsp;';
                        }
                    }
                    echo '</p>';
                    ?>
                </div>
                <div class="layui-form  layui-tab-item">
                    <div class="layui-form-item">
                        <label class="layui-form-label">商品分类</label>
                        <div class="layui-input-block">
                            <select name="goodsType" lay-verify="">
                                <?php
                                $pp_plugin_shequ_zbpFunction = new pp_plugin_shequ_zbpFunction();
                                foreach($pp_plugin_shequ_zbpFunction->pp_plugin_shequ_shop_getGoodsTypeList() as $goodsType){
                                    echo '<option value="'.$goodsType->ID.'">'.$goodsType->Name.'</option>';
                                }
                                ?>
                            </select>

                        </div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label">商品名称</label>
                        <div class="layui-input-block">
                            <input name="goodsname" class="layui-input" required lay-verify="required" />
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label">商品图片</label>
                        <div class="layui-input-block" style="height: 100px;">
                            <img id="L_goods_img" src="">
                            <i id="L_goods_img_btn" class="layui-icon" style="cursor:pointer;font-size: 80px;position: absolute;top: 5px;">&#xe608;</i>
                            <input id="L_goods_img_path" type="hidden" name="goodspic" value="">
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <div class="layui-inline">
                            <label class="layui-form-label">商品价格</label>
                            <div class="layui-input-inline">
                                <input name="goodsprice" class="layui-input" required lay-verify="required" />
                            </div>
                        </div>
                        <div class="layui-inline">
                            <label class="layui-form-label">促销价</label>
                            <div class="layui-input-inline">
                                <input name="goodsprice_cx" class="layui-input"/>
                            </div>
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label">是否促销</label>
                        <div class="layui-input-inline" >
                            <input type="checkbox" name="shifoucuxiao" lay-skin="switch" lay-text="开启|关闭">
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label">促销类型</label>
                        <div class="layui-input-inline" >
                            <input type="radio" name="cuxiaofenlei" lay-filter="cuxiaofenlei" value="1" title="时间" checked>
                            <input type="radio" name="cuxiaofenlei" lay-filter="cuxiaofenlei" value="2" title="数量" >
                        </div>
                    </div>
                    <div class="layui-form-item" id="cuxiaofenlei_sj">
                        <label class="layui-form-label">促销时间</label>
                        <div class="layui-input-inline">
                            <input name="cuxiaoshijian_ks" class="layui-input" id="cuxiaoshijian_ks"/>
                        </div>
                        <div class="layui-input-inline">
                            <input name="cuxiaoshijian_js" class="layui-input" id="cuxiaoshijian_js"/>
                        </div>
                    </div>
                    <div class="layui-form-item layui-hide" id="cuxiaofenlei_sl">
                        <label class="layui-form-label">促销数量</label>
                        <div class="layui-input-block">
                            <input name="cuxiaoshuliang" class="layui-input"/>
                        </div>
                    </div>
                    <div class="layui-form-item layui-form-text">
                        <label class="layui-form-label">购买须知</label>
                        <div class="layui-input-block">
                            <textarea id="L_desc" placeholder="请输入内容" class="layui-textarea"></textarea>
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
                            <textarea id="L_info" placeholder="请输入内容" class="layui-textarea" ></textarea>
                        </div>
                    </div>
                    <div class="layui-form-item layui-form-text" style="text-align: center">
                        <button class="layui-btn" lay-submit lay-filter="goodssubmit">提交</button>
                    </div>
                </div>
                <div class="layui-tab-item">
                    <button class="layui-btn" id="L_tianjiafenlei">添加分类</button>
                    <table class="layui-table">
                        <colgroup>
                            <col width="100">
                            <col>
                            <col width="200">
                        </colgroup>
                        <thead>
                        <tr>
                            <th>编号</th>
                            <th>名称</th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $pp_plugin_shequ_zbpFunction = new pp_plugin_shequ_zbpFunction();
                        foreach($pp_plugin_shequ_zbpFunction->pp_plugin_shequ_shop_getGoodsTypeList() as $goodsType){?>
                        <tr class="layui-form">
                            <td><?php echo $goodsType->ID;?></td>
                            <td><?php echo $goodsType->Name;?></td>
                            <td>
                                <input type="hidden" name="id" value="<?php echo $goodsType->ID;?>">
                                <input type="hidden" name="name" value="<?php echo $goodsType->Name;?>">
                                <button class="layui-btn layui-btn-xs" lay-submit lay-filter="xiugai">修改</button>
                                <button class="layui-btn layui-btn-xs layui-btn-danger" lay-submit lay-filter="shanchu">删除</button>
                            </td>
                        </tr>
                        <?php };?>
                        </tbody>
                    </table>
                </div>
                <div class="layui-form layui-form-pane layui-tab-item">
                    <div class="layui-form-item">
                        <table class="layui-table">
                            <colgroup>
                                <col width="120">
                                <col>
                                <col width="100">
                                <col width="80">
                                <col width="120">
                            </colgroup>
                            <thead>
                            <tr>
                                <th>订单编号</th>
                                <th>购买商品</th>
                                <th>价格</th>
                                <th>用户ID</th>
                                <th>下单时间</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $p1 = new pp_plugin_shequ_pagebar('{%host%}shequ/user/shop/{%page%}.html#tab=yslb', false);
                            $p1->PageCount = 20;//$zbp->managecount;
                            $p1->PageNow = count($url_parm_arr)==5?$url_parm_arr[4]:1;
                            $p1->PageBarCount = $zbp->pagebarcount;

                            $pp_plugin_shequ_goods_order_sql=$zbp->db->sql->select(
                                $zbp->table['pp_plugin_shequ_orders'],
                                '*',
                                '',
                                'order_posttime desc'
                                ,array(($p1->PageNow - 1) * $p1->PageCount, $p1->PageCount),
                                array('pagebar' => $p1)
                            )
                            ?>
                            <?php
                            //$pp_plugin_shequ_shop_getOrdersList = new pp_plugin_shequ_zbpFunction();
                            foreach((new pp_plugin_shequ_zbpFunction())->pp_plugin_shequ_shop_getOrdersList($pp_plugin_shequ_goods_order_sql) as $order){?>
                                <tr>
                                    <td><?php echo $order->OrderNumber;?></td>
                                    <td><?php echo $order->Name;?></td>
                                    <td><?php echo $order->Money;?></td>
                                    <td><?php echo $order->UserId;?></td>
                                    <td><?php echo date('Y-m-d',$order->PostTime);?></td>
                                </tr>
                            <?php };?>
                            </tbody>
                        </table>
                        <?php
                        echo '<hr/><p class="pagebar">';
                        foreach ($p1->Buttons as $key => $value) {
                            if ($p1->PageNow == $key) {
                                echo '<span class="now-page">' . $key . '</span>&nbsp;&nbsp;';
                            } else {
                                echo '<a href="' . $value . '">' . $key . '</a>&nbsp;&nbsp;';
                            }
                        }
                        echo '</p>';
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php require ZBP_PATH . 'zb_users/plugin/pp_plugin_shequ/html/footer.php'; ?>
<script>
    layui.use(['element','form','layedit','laydate','upload'],function(){
        var element = layui.element,form=layui.form,layedit = layui.layedit,laydate=layui.laydate,upload=layui.upload;
        layedit.set({uploadImage: {url: '<?php echo $zbp->host;?>zb_users/plugin/pp_plugin_shequ/html/user/cmd.php?act=upload'}});
        var editIndex_desc=layedit.build('L_desc'); //建立编辑器
        var editIndex_info=layedit.build('L_info'); //建立编辑器
        //var content = layedit.getContent(editIndex_desc);//获取编辑器内容

        form.on('submit(shanchu)',function(data){
            var loadIndex = layer.load();

            var url = '<?php echo $zbp->host;?>zb_users/plugin/pp_plugin_shequ/html/user/cmd.php?act=goodsTypeDel';
            $.post(url, data.field, function (res) {
                if (res == 1) {
                    layer.alert('删除成功', function () {
                        layer.close(loadIndex);
                        window.location.reload();
                        return false;
                    })
                } else {
                    layer.msg('删除失败', function () {});
                    layer.close(loadIndex);
                    return false;
                }
            })
            return false;
        })

        form.on('submit(xiugai)',function(data) {
            layer.open({
                type: 1,
                title: '修改分类',
                area: ['600px', '400px'],
                content: [
                    '<div class="layui-form">'
                    , '<div class="layui-form-item">'
                    , '<label class="layui-form-label">分类名称</label>'
                    , '<div class="layui-input-block">'
                    , '<input name="id" type="hidden" class="layui-input" value="' + data.field.id + '"/>'
                    , '<input name="mingcheng" class="layui-input" value="' + data.field.name + '"/>'
                    , '</div>'
                    , '</div>'
                    , '<div class="layui-form-item">'
                    , '<div class="layui-input-block">'
                    , '<button class="layui-btn" lay-submit lay-filter="baocun">保存修改</button>'
                    , '</div>'
                    , '</div>'
                    , '</div>'
                ].join(''),
                success: function (index, layero) {
                    form.on('submit(baocun)', function (data) {
                        var loadIndex = layer.load();

                        var url = '<?php echo $zbp->host;?>zb_users/plugin/pp_plugin_shequ/html/user/cmd.php?act=goodsTypeEdit';
                        $.post(url, data.field, function (res) {
                            if (res == 1) {
                                layer.alert('保存成功', function () {
                                    layer.close(loadIndex);
                                    window.location.reload();
                                    return false;
                                })
                            } else {
                                layer.msg('保存失败', function () {});
                                layer.close(loadIndex);
                                return false;
                            }
                        })
                        return false;
                    })
                }
            })
            return false;
        })

        $("#L_tianjiafenlei").on('click',function(){
            layer.open({
                type:1,
                title:'添加分类',
                area:['600px','400px'],
                content:[
                    '<div class="layui-form">'
                        ,'<div class="layui-form-item">'
                            ,'<label class="layui-form-label">分类名称</label>'
                            ,'<div class="layui-input-block">'
                                ,'<input name="mingcheng" class="layui-input" />'
                            ,'</div>'
                        ,'</div>'
                        ,'<div class="layui-form-item">'
                            ,'<div class="layui-input-block">'
                                ,'<button class="layui-btn" lay-submit lay-filter="baocun">保存</button>'
                            ,'</div>'
                        ,'</div>'
                    ,'</div>'
                ].join('')
                ,success:function(index,layero){
                    form.on('submit(baocun)',function(data){
                        var loadIndex = layer.load();

                        var url = '<?php echo $zbp->host;?>zb_users/plugin/pp_plugin_shequ/html/user/cmd.php?act=goodsTypeAdd';
                        $.post(url,data.field,function(res){
                            if(res==1){
                                layer.alert('保存成功',function(){
                                    layer.close(loadIndex);
                                    window.location.reload();
                                    return false;
                                })
                            }else{
                                layer.msg('保存失败',function(){});
                                layer.close(loadIndex);
                                return false;
                            }
                        })
                        return false;
                    })
                }
            })
        })

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

        $("button[name=goodslist_shanchu]").on('click',function(){
            var that = this;
            layer.confirm('确定要删除吗？',function(){
                var loadIndex = layer.load();
                var goodsid = $(that).attr("data_id"); //商品ID
                var url = '<?php echo $zbp->host;?>zb_users/plugin/pp_plugin_shequ/html/user/cmd.php?act=goodsDel';
                $.post(url,{goodsid:goodsid},function(res){
                    if(res==1){
                        layer.alert('删除成功',function(){
                            window.location.reload();
                            return false;
                        })
                    }else{
                        layer.msg('删除失败',function(){});
                        layer.close(loadIndex);
                        return false;
                    }
                })
            },function(index){
                layer.close(index);
            })

        })

        $("button[name=goodslist_bianji]").on('click',function(){
            var goodsid = $(this).attr("data_id"); //商品ID

            layer.open({
                type:2,
                title:'商品编辑',
                area:['80%','90%'],
                content:'<?php echo $zbp->host;?>zb_users/plugin/pp_plugin_shequ/html/shop/goodsinfo.php?goodsid='+goodsid,
            })
        })

        //保存修改
        form.on('submit(goodssubmit)',function(data){
            var loadIndex = layer.load();
            data.field.shifoucuxiao=data.field.shifoucuxiao||"off";
            data.field.desc = layedit.getContent(editIndex_desc)||'';
            data.field.content = layedit.getContent(editIndex_info)||'';

            var url = '<?php echo $zbp->host;?>zb_users/plugin/pp_plugin_shequ/html/user/cmd.php?act=goodsAdd';
            $.post(url,data.field,function(res){
                if(res==1){
                    layer.alert('添加成功',function(index){
                        window.location.reload();
                        return false;
                    });

                    return false;
                }else{
                    layer.msg('添加失败',function(){});
                    layer.closeAll();
                    return false;
                }
            })
            return false;
        })

        form.on('radio(cuxiaofenlei)', function(data){
            if(data.value==1){
                $("#cuxiaofenlei_sj").addClass('layui-show');
                $("#cuxiaofenlei_sl").addClass('layui-hide');
                $("#cuxiaofenlei_sj").removeClass('layui-hide');

            }else{
                $("#cuxiaofenlei_sl").addClass('layui-show');
                $("#cuxiaofenlei_sj").addClass('layui-hide');
                $("#cuxiaofenlei_sl").removeClass('layui-hide');
            }
        });

        laydate.render({
            elem: '#cuxiaoshijian_ks'
            ,format: 'yyyy-MM-dd'
        });

        laydate.render({
            elem: '#cuxiaoshijian_js'
            ,format: 'yyyy-MM-dd'
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
