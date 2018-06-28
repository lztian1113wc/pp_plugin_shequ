<?php
/**
 * Created by PhpStorm.
 * User: wangchuan
 * Date: 2018/5/15
 * Time: 15:53
 */

global $zbp;
$pp_plugin_shequ_shop_goodsid = is_numeric($url_parm_arr[4]) ? $url_parm_arr[4] : 0;

$pp_plugin_shequ_shop_goodsinfo = $zbp->pp_plugin_shequ_getgoodsinfo($pp_plugin_shequ_shop_goodsid);
$pagetitle=$pp_plugin_shequ_shop_goodsinfo->Name;

require ZBP_PATH . 'zb_users/plugin/pp_plugin_shequ/html/header.php';
?>
<link rel="stylesheet" href="<?php echo $zbp->host; ?>zb_users/plugin/pp_plugin_shequ/res/css/reset.css">
<link rel="stylesheet" href="<?php echo $zbp->host; ?>zb_users/plugin/pp_plugin_shequ/res/css/shopinfo.css">
<div class="layui-container fly-marginTop">
    <div class="fly-panel">
        <div class="fly-none layui-form">
            <div class="layui-form-item" style="position: relative;height: 410px;">
                <div class="shop-info-left">
                    <img src="<?php echo $pp_plugin_shequ_shop_goodsinfo->Metas->goodspic; ?>">
                </div>
                <div class="shop-info-right">
                    <div class="top"><?php echo $pp_plugin_shequ_shop_goodsinfo->Name; ?></div>
                    <div class="content">
                        <hr/>
                        <p><strong>商品价格</strong> <?php echo $pp_plugin_shequ_shop_goodsinfo->Metas->goodsprice; ?> 元</p>
                        <hr/>
                        <?php if ($pp_plugin_shequ_shop_goodsinfo->Metas->shifoucuxiao == 'on') { ?>
                            <p style="color:#FF5722">
                                <strong>促销价</strong> <?php echo $pp_plugin_shequ_shop_goodsinfo->Metas->goodsprice_cx; ?>
                                元</p>
                            <hr/>
                            <?php if ($pp_plugin_shequ_shop_goodsinfo->Metas->cuxiaofenlei == 1) { ?>
                                <p>
                                    <strong>活动结束日期</strong> <?php echo $pp_plugin_shequ_shop_goodsinfo->Metas->cuxiaoshijian_js; ?>
                                </p>
                                <hr/>
                            <?php } else if ($pp_plugin_shequ_shop_goodsinfo->Metas->cuxiaofenlei == 2) { ?>
                                <p>
                                    <strong>活动剩余数量</strong> <?php echo $pp_plugin_shequ_shop_goodsinfo->Metas->cuxiaoshuliang; ?>
                                    个</p>
                                <hr/>
                            <?php }
                        }; ?>
                        <p><strong>上架时间</strong> <?php echo date('Y-m-d', $pp_plugin_shequ_shop_goodsinfo->PostTime); ?>
                        </p>
                        <hr/>
                    </div>
                    <div class="bottom">
                        <button class="layui-btn" id="fukuan_zfb"
                                data_id="<?php echo $pp_plugin_shequ_shop_goodsid; ?>">支付宝付款
                        </button>
                    </div>
                </div>
            </div>
            <div class="layui-form-item">
                <div class="layui-tab layui-tab-brief" lay-filter="goods">
                    <ul class="layui-tab-title">
                        <li class="layui-this" lay-id="xx">详细介绍</li>
                        <li lay-id="pl">用户评论</li>
                        <li lay-id="desc">购买说明</li>
                    </ul>
                    <div class="layui-tab-content">
                        <div class="layui-tab-item layui-show markdown">
                            <?php echo $pp_plugin_shequ_shop_goodsinfo->Content; ?>
                        </div>
                        <div class="layui-tab-item">
                            <ul>
                                <?php

                                $p = new pp_plugin_shequ_pagebar('{%host%}shequ/shop/info/'.$pp_plugin_shequ_shop_goodsid.'/{%page%}.html#goods=pl', false);
                                $p->PageCount = 10;//$zbp->managecount;
                                $p->PageNow = count($url_parm_arr)==6?$url_parm_arr[5]:1;
                                $p->PageBarCount = $zbp->pagebarcount;

                                $pp_plugin_shequ_goods_comment_sql = $zbp->db->sql->select(
                                    $zbp->table['pp_plugin_shequ_goods_comment'] . ' a left join ' . $zbp->table['Member'] . ' b on a.comm_UserId=b.mem_id left join ' . $zbp->table['pp_plugin_shequ_user'] . ' c on a.comm_UserId = c.userid'
                                    , '*',
                                    array('=','comm_GoodsId',$pp_plugin_shequ_shop_goodsid),
                                    'comm_Time desc',
                                    array(($p->PageNow - 1) * $p->PageCount, $p->PageCount),
                                    array('pagebar' => $p)
                                );
                                //echo $pp_plugin_shequ_goods_comment_sql;
                                $pp_plugin_shequ_goods_comment_arr = $zbp->db->query($pp_plugin_shequ_goods_comment_sql);
                                foreach ($pp_plugin_shequ_goods_comment_arr as $pp_plugin_shequ_goods_comment) {
                                    ?>
                                    <li data-id="111" class="jieda-daan" style="padding: 20px 0 10px; border-bottom: 1px dotted #DFDFDF;">
                                        <a name="item-1111111111"></a>
                                        <div class="detail-about detail-about-reply">
                                            <a class="fly-avatar" href="/shequ/user/home/1.html">
                                                <img src="<?php
                                                if(!empty($pp_plugin_shequ_goods_comment['userface'])){
                                                    echo $pp_plugin_shequ_goods_comment['userface'];
                                                }else{
                                                    echo $zbp->host.'zb_users/plugin/pp_plugin_shequ/userface.jpg';
                                                }?>" alt="">
                                            </a>
                                            <div class="fly-detail-user">
                                                <a href="/shequ/user/home/1.html" class="fly-link">
                                                    <cite><?php echo $pp_plugin_shequ_goods_comment['mem_Alias'] ?></cite>
                                                </a>
                                            </div>
                                            <div class="detail-hits">
                                                <span><?php echo date('Y-m-d', $pp_plugin_shequ_goods_comment['comm_Time']) ?></span>
                                            </div>
                                        </div>
                                        <div class="detail-body jieda-body photos">
                                            <?php echo $pp_plugin_shequ_goods_comment['comm_Content'] ?>
                                        </div>
                                        <div class="jieda-reply">
                                        <span name="L_huifu" goods_id="<?php echo $pp_plugin_shequ_shop_goodsid; ?>"
                                              comm_id="<?php echo $pp_plugin_shequ_goods_comment['comm_ID']; ?>"
                                              mem_id="<?php echo $zbp->user->ID; ?>"
                                              mem_alias="<?php echo $pp_plugin_shequ_goods_comment['mem_Alias'] ?>"
                                              type="reply">
                                            <i class="iconfont icon-svgmoban53"
                                               style="line-height: 16px;font-size: 16px;color: #393D49;"></i>回复
                                        </span>
                                            <?php if($zbp->CheckRights('root')){?>
                                            <div style="position: absolute;left: 70px;top: 0px;">
                                                <span name="L_shanchu"
                                                      goods_id="<?php echo $pp_plugin_shequ_shop_goodsid; ?>"
                                                      comm_id="<?php echo $pp_plugin_shequ_goods_comment['comm_ID']; ?>"
                                                      type="del">删除</span>
                                            </div>
                                            <?php };?>
                                        </div>
                                    </li>
                                <?php }; ?>
                                <?php if (count($pp_plugin_shequ_goods_comment_arr) == 0) { ?>
                                    <li style="height:100px;text-align: center;line-height: 100px">暂无评论</li>
                                <?php }; ?>
                            </ul>
                            <?php
                            if (count($pp_plugin_shequ_goods_comment_arr) >0){
                                echo '<hr/><p class="pagebar">';
                                foreach ($p->Buttons as $key => $value) {
                                    if ($p->PageNow == $key) {
                                        echo '<span class="now-page">' . $key . '</span>&nbsp;&nbsp;';
                                    } else {
                                        echo '<a href="' . $value . '">' . $key . '</a>&nbsp;&nbsp;';
                                    }
                                }
                                echo '</p>';
                            }
                            ?>
                            <hr />
                            <div class="layui-form layui-form-pane">
                                <?php if (!empty($zbp->user->ID)) { ?>
                                    <form id="comment_form">
                                        <div class="layui-form-item layui-form-text">
                                            <a name="comment"></a>
                                            <div class="layui-input-block">
                                <textarea id="L_content" name="content"
                                          placeholder="请输入内容" class="layui-textarea fly-editor"
                                          style="height: 150px;"></textarea>
                                            </div>
                                        </div>
                                        <div class="layui-form-item">
                                            <input type="hidden" name="jid" value="123">
                                            <input type="button" class="layui-btn" id="tijiaohuifu"
                                                   value="提交回复"></input>
                                        </div>
                                    </form>
                                <?php } else { ?>
                                    <hr/>
                                    <p style="text-align: center">
                                        <a href="<?php echo $zbp->host ?>shequ/user/login.html">登陆</a>后回复
                                    </p>
                                <?php }; ?>
                            </div>
                        </div>
                        <div class="layui-tab-item markdown">
                            <?php echo $pp_plugin_shequ_shop_goodsinfo->Desc; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
</div>

<?php require ZBP_PATH . 'zb_users/plugin/pp_plugin_shequ/html/footer.php'; ?>
<script>
    layui.use(['element','layedit'], function () {
        var element = layui.element,layedit=layui.layedit;
        layedit.set({uploadImage: {url: '<?php echo $zbp->host;?>zb_users/plugin/pp_plugin_shequ/html/user/cmd.php?act=upload'}});
        var edit_index = layedit.build('L_content',{
            tool: ['strong','italic','underline','del','|','left','center','right','link','unlink']
        }); //建立编辑器

        $("span[name=L_huifu]").on("click",function(){
            var that = this;
            var commId = $(this).attr("comm_id")||0;
            var goods_id = $(this).attr("goods_id");
            var memId = $(this).attr("mem_id");
            var memAlias = $(this).attr("mem_Alias");
            location.href='#comment';
            layedit.setContent(edit_index,"@"+memAlias+"&nbsp;",true);

            //禁用按钮
            $(that).addClass("layui-btn-disabled");

            var goodsid =<?php echo $pp_plugin_shequ_shop_goodsid; ?>;
            var url = '<?php echo $zbp->host;?>zb_users/plugin/pp_plugin_shequ/html/user/cmd.php?act=goodsCommentAdd';
            $.post(url, {
                pid:commId,
                goodsid:goods_id,
                content: layedit.getContent(edit_index)
            }, function () {
                window.location.reload();
            })

        })

        $("#tijiaohuifu").on('click', function () {
            var that = this;
            if (layedit.getText(edit_index).length < 2) {
                layer.msg('评论字数太少了', function () {
                });
                return false;
            } else {
                //禁用按钮
                $(that).addClass("layui-btn-disabled");

                var goodsid =<?php echo $pp_plugin_shequ_shop_goodsid; ?>;
                var url = '<?php echo $zbp->host;?>zb_users/plugin/pp_plugin_shequ/html/user/cmd.php?act=goodsCommentAdd';
                $.post(url, {
                    pid:0,
                    goodsid:goodsid,
                    content: layedit.getContent(edit_index)
                }, function () {
                    window.location.reload();
                })
            }
        })

        $("#fukuan_zfb").on('click', function () {
            var goodsid = $(this).attr('data_id');
            var url = '<?php echo $zbp->host;?>zb_users/plugin/pp_plugin_shequ/html/user/cmd.php?act=buyGoods';
            window.location.href = url + "&goodsid=" + goodsid;

        })

        //获取hash来切换选项卡，假设当前地址的hash为lay-id对应的值
        var layid = location.hash.replace(/^#goods=/, '');
        element.tabChange('goods', layid);

        //监听Tab切换，以改变地址hash值
        element.on('tab(goods)', function () {
            location.hash = 'goods=' + this.getAttribute('lay-id');
        });
    });
</script>


