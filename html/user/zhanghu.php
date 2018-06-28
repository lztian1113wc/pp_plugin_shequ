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
            <a href="set.html">
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
        <li class="layui-nav-item layui-this">
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
<!--                <li  lay-id="zhxx">账户信息</li>-->
                <li lay-id="ygsp" class="layui-this">已购商品</li>
                <!--                <li lay-id="bind">帐号绑定</li>-->
            </ul>
            <div class="layui-tab-content" style="padding: 20px 0;">
                <div class="layui-form layui-tab-item ">
                    <div class="layui-form-item">
                        <div class="layui-form-label">账户余额</div>
                        <div class="layui-input-block">
                            <p style="line-height: 36px;margin-left: 10px;">
                                <?php echo is_null($zbp->user->Metas->pp_plugin_shequ_yue)?0:$zbp->user->Metas->pp_plugin_shequ_yue ; ?>元
                            </p>
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <div class="layui-form-label">账户充值</div>
                        <div class="layui-input-block" id="L_chongzhije" style="line-height: 36px;">
                            <?php
                                $pp_plugin_shequ_chongzhijine = $zbp->Config('pp_plugin_shequ')->mzfczje;
                                $pp_plugin_shequ_chongzhijineArr = explode("|",$pp_plugin_shequ_chongzhijine);
                                foreach ($pp_plugin_shequ_chongzhijineArr as $price) {
                                    echo '<button class="layui-btn layui-btn-primary layui-btn-sm" style="width:100px" data_value="'.$price.'">'.$price.'</button>';
                                }
                            ?>
                        </div>
                    </div>
                    <div class="layui-input-block">
                        <button class="layui-btn layui-btn-sm" lay-submit lay-filter="chongzhi">账户充值</button>
                    </div>
                </div>

                <div class="layui-form layui-tab-item layui-show">
                    <table class="layui-table">
                        <colgroup>
                            <col width="120">
                            <col>
                            <col width="100">
                            <col width="100">
                        </colgroup>
                        <thead>
                        <tr>
                            <th>订单编号</th>
                            <th>购买商品</th>
                            <th>价格</th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $p = new pp_plugin_shequ_pagebar('{%host%}shequ/user/zhanghu/{%page%}.html', false);
                        $p->PageCount = 20;//$zbp->managecount;
                        $p->PageNow = count($url_parm_arr)==5?$url_parm_arr[4]:1;
                        $p->PageBarCount = $zbp->pagebarcount;

                        $pp_plugin_shequ_goods_order_sql=$zbp->db->sql->select(
                            $zbp->table['pp_plugin_shequ_orders'],
                            '*',
                            array('=','order_UserId',$zbp->user->ID),
                            'order_posttime desc'
                            ,array(($p->PageNow - 1) * $p->PageCount, $p->PageCount),
                            array('pagebar' => $p)
                        )
                        ?>
                        <?php foreach($zbp->pp_plugin_shequ_shop_getOrdersList($pp_plugin_shequ_goods_order_sql) as $order){?>
                        <tr>
                            <td><?php echo $order->OrderNumber;?></td>
                            <td><?php echo $order->Name;?></td>
                            <td><?php echo $order->Money;?></td>
                            <td>
                                <button class="layui-btn layui-btn-xs" name="L_qiquma" data_id="<?php echo $order->GoodsID;?>">下载</button>
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
            </div>
        </div>
    </div>
</div>
<?php require ZBP_PATH . 'zb_users/plugin/pp_plugin_shequ/html/footer.php'; ?>
<script>
    layui.use(['element','form'],function(){
        var element = layui.element,form=layui.form;
        var czjine=0;

        $("button[name=L_qiquma]").on('click',function(){
            var that=this;
            var id=$(that).attr('data_id');
            layer.open({
                type:2
                ,title:'提取商品'
                ,area:['400px','300px']
                ,content:'<?php echo $zbp->host?>zb_users/plugin/pp_plugin_shequ/html/shop/goodsget.php?goodsid='+id
            })
        })

        $("#L_chongzhije").find('button').on('click',function(){
            var that = this;
            var data_value = $(that).attr('data_value')||'0';

            czjine=data_value;
            $(that).parent().find('button').removeClass('layui-btn-danger').css({color:'#333'});
            $(that).addClass('layui-btn-danger').css({color:'#fff'});
        })

        form.on('submit(chongzhi)',function(data){
            czjine = czjine|| 0;
            if(czjine==0){
                layer.msg('请选择金额',function(){});
                return false;
            }

            var url = '<?php echo $zbp->host;?>zb_users/plugin/pp_plugin_shequ/html/user/cmd.php?act=createOrder';
            window.location.href=url+"&price="+czjine;
            return false;
        })

        //获取hash来切换选项卡，假设当前地址的hash为lay-id对应的值
        var layid = location.hash.replace(/^#tab=/, '');
        element.tabChange('user', layid);

        //监听Tab切换，以改变地址hash值
        element.on('tab(user)', function(){
            location.hash = 'tab='+ this.getAttribute('lay-id');
        });
    })
</script>
